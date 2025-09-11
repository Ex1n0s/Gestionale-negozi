
-- TRIGGERS TESSERA FEDELTA
create or replace function check_negozio_tessera_fedelta()
returns trigger as $$
begin
	if is_attivo_negozio(new.codice_negozio) = false then
		raise exception 'Una nuova tessera fedeltà non può essere rilasciata da un negozio chiuso';
	end if;
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_check_negozio_tessera_fedelta
	before insert on tessera_fedelta
	for each row
	execute function check_negozio_tessera_fedelta();


-- TRIGGERS ORARIO
create or replace function check_validita_orario()
returns trigger as $$
begin
	if is_attivo_negozio(new.codice_negozio) = false then
		raise exception 'Non puoi aggiungere un orario a un negozio chiuso';
	end if;
	new.giorno := LOWER(new.giorno);
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_validita_orario
	before insert or update on orario
	for each row
	execute function check_validita_orario();


-- TRIGGERS FATTURA

/*
Applicazione sconto sulla spesa. Al raggiungimento di determinate soglie di punti,
vengono sbloccati alcuni sconti. In particolare: a 100 punti si sblocca uno sconto del 5%, a
200 punti del 15%, a 300 punti del 30%. Si noti che lo sconto non può mai essere più elevato
di 100 Euro. L’applicazione dello sconto avviene su scelta del cliente, e lo sconto viene
applicato sul totale della fattura sulla quale viene applicato. In seguito all’applicazione
dello sconto, il saldo punti della tessera fedeltà deve essere decurtato del numero di punti
usato per lo sconto.
*/
create or replace function fattura_BI()
returns trigger as $$
declare
	punti_da_togliere INTEGER;
	sconto DECIMAL(10,2) := 0;
begin
	
	select sd.costo_punti into punti_da_togliere
	from sconti_disponibili(new.cf_cliente) sd
	where new.sconto_percentuale = sd.sconto_percentuale;

	--contollo se il cliente ha abbastanza punti per applicare lo sconto selezionato
	if punti_da_togliere is null then
		--se il cliente non ha la tessera o abbastanza punti lo sconto applicato sarà dello 0%
		new.sconto_percentuale := 0;
	else
		--se il cliente puo applicare lo sconto vengono rimossi i punti dalla tessera fedeltà
		--e viene calcolato il totale con sconto applicato
		update tessera_fedelta tf
		set punti = punti - punti_da_togliere
		where tf.cf_cliente = new.cf_cliente;

		sconto := new.totale * (new.sconto_percentuale/100);
		if sconto > 100 then
		sconto := 100;
		end if;
		new.totale := new.totale - sconto;
	end if;
	
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_fattura_BI
	before insert on fattura
	for each row
	execute function fattura_BI();

/*
Aggiorna il saldo punti su tessera fedeltà. Per ogni Euro speso, viene accumu-
lato un punto sulla tessera del cliente che effettua la spesa. Il saldo punti su ogni tessera
deve essere continuamente aggiornato.

Inoltre garantisce che ogni fattura abbia almeno una riga fattura, in caso contrario cancella l'insert.

L'inserimento della fattura e delle righe della fattura deve avvenire nella stessa transazione in quanto il
trigger differito verrà eseguito al commit della transazione in cui viene fatto l'insert, 
permettendo quindi di inserire prima la fattura e poi le sue righe.
*/
create or replace function fattura_AI()
returns trigger as $$
declare
	righe INTEGER := 0;
begin
	select COUNT(*) into righe
	from riga_fattura rf
	where rf.codice_fattura = new.codice;
	if righe = 0 then
		raise exception 'Ogni fattura deve avere almeno una riga';
	end if;
	update tessera_fedelta tf
	set punti = punti + floor(new.totale)
	where tf.cf_cliente = new.cf_cliente;
	return new;
end;
$$ language plpgsql;

create constraint trigger TR_fattura_AI
	after insert on fattura
	deferrable initially deferred
	for each row
	execute function fattura_AI();

-- TRIGGERS RIGA FATTURA

create or replace function check_negozio_riga_fattura()
returns trigger as $$
begin
	if is_attivo_negozio(new.codice_negozio) = false then
		raise exception 'Una nuova riga fattura non può riferire un negozio chiuso';
	end if;
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_check_negozio_riga_fattura
	before insert on riga_fattura
	for each row
	execute function check_negozio_riga_fattura();

-- TRIGGERS NEGOZIO

/*
Mantenimento storico tessere. Quando un negozio viene eliminato, e' necessario mantenere
in una tabella di storico le informazioni sulle tessere che erano state emesse dal
negozio stesso, con la data di emissione.
*/
create or replace function chiusura_negozio()
returns trigger as $$
begin
	
	insert into tessera_fedelta_archivio(numero_tessera,data_richiesta,data_emissione,codice_negozio)
	select tf.numero, tf.data_richiesta, tf.data_emissione, tf.codice_negozio
	from tessera_fedelta tf
	where tf.codice_negozio = new.codice and 
		  tf.numero not in (select numero_tessera as numero from tessera_fedelta_archivio);
	
	delete from orario
	where codice_negozio = new.codice;
	
	delete from vende
	where codice_negozio = new.codice;

	update ordine
	set stato = 'annullato'
	where stato = 'confermato' and codice_negozio = new.codice;

	return new;
end;
$$ language plpgsql;

create or replace trigger TR_chiusura_negozio
	after update of attivo on negozio
	for each row
	when (new.attivo = false and old.attivo = true)
	execute function chiusura_negozio();


-- TRIGGERS VENDE

create or replace function check_negozio_vende()
returns trigger as $$
begin
	if is_attivo_negozio(new.codice_negozio) = false then
		raise exception 'Un negozio chiuso non può vendere prodotti';
	end if;
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_check_negozio_vende
	before insert or update on vende
	for each row
	execute function check_negozio_vende();

-- TRIGGERS FORNITORE
create or replace function chiusura_fornitore()
returns trigger as $$
begin
	delete from fornisce
	where iva_fornitore = new.iva;
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_chiusura_fornitore
	after update of attivo on fornitore
	for each row
	when (new.attivo = false and old.attivo = true)
	execute function chiusura_fornitore();

-- TRIGGERS FORNISCE

create or replace function check_fornitore_fornisce()
returns trigger as $$
declare 
	stato_fornitore BOOLEAN;
begin
	select attivo into stato_fornitore
	from fornitore
	where iva = new.iva_fornitore;

	if stato_fornitore = false then
		raise exception 'Un fornitore chiuso non può fornire prodotti';
	end if;
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_check_fornitore_fornisce
	before insert or update on fornisce
	for each row
	execute function check_fornitore_fornisce();

-- TRIGGERS ORDINE

/*
Aggiornamento disponibilità prodotti dai fornitori. La disponibilità dei 
prodotti dai vari fornitori è ovviamente limitata (e comunicata da ciascun fornitore alla catena di negozi). 
In seguito ad un ordine di un certo prodotto presso un certo fornitore, è necessario mantenere 
aggiornata la disponibilità di quel prodotto da quel fornitore.

Ordine prodotti da fornitore. Quando un prodotto deve essere rifornito di una certa quantità,
è necessario inserire un ordine presso un determinato fornitore. 
Il fornitore deve essere automaticamente scelto sulla base del criterio 
di economicità (vale a dire, l'ordine viene automaticamente effettuato presso il fornitore che,
oltre ad avere disponibilità di prodotto sufficiente, offre il costo minore).
*/
create or replace function ordine_BI()
returns trigger as $$
declare
	iva_fornitore VARCHAR(11);
	prezzo_prodotto DECIMAL(10,2);
begin
	if is_attivo_negozio(new.codice_negozio) = false then
		raise exception 'Non è possibile inserire un ordine per un negozio chiuso';
	end if;
	--selezione del fornitore attivo che fornisce il prodotto ad un costo minore
	select f.iva_fornitore,f.prezzo_prodotto into iva_fornitore,prezzo_prodotto
	from fornitore ft join fornisce f on ft.iva = f.iva_fornitore 
	where f.codice_prodotto = new.codice_prodotto and new.quantita_prodotto <= f.quantita_disponibile and ft.attivo = true
	order by f.prezzo_prodotto asc
	limit 1;

	if iva_fornitore is null then
		raise exception 'Prodotto non disponibile da nessun fornitore.';
	end if;
	new.iva_fornitore := iva_fornitore;
	new.prezzo_prodotto := prezzo_prodotto;

	update fornisce f
	set quantita_disponibile = quantita_disponibile - new.quantita_prodotto
	where f.iva_fornitore = new.iva_fornitore and f.codice_prodotto = new.codice_prodotto;
	
	new.stato := 'confermato';
	new.data_consegna := null;
	return new;
end;
$$ language plpgsql;


create or replace trigger TR_ordine_BI
	before insert on ordine
	for each row
	execute function ordine_BI();


create or replace function gestione_stato_ordine()
returns trigger as $$
begin
	if old.stato = 'confermato' and new.stato = 'annullato'  then
		new.data_consegna := null;
	elseif old.stato = 'confermato' and new.stato = 'consegnato' then 
		new.data_consegna := current_date;
	else
		new.stato = old.stato;
		new.data_consegna = old.data_consegna;
	end if;

	new.quantita_prodotto := old.quantita_prodotto;
	new.prezzo_prodotto := old.prezzo_prodotto;
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_gestione_stato_ordine
	before update on ordine
	for each row
	execute function gestione_stato_ordine();
	
/*
Quando lo stato passa da confermato a consegnato, la quantità di 
prodotto ordinata viene automaticamente aggiunta alla quantità disponibile nel negozio.
Nel caso in cui il negozio non abbia ancora un record in vende per il prodotto ordinato, verrà 
inserito un record in vende per il prodotto con:
	Quantità disponibile = quantità prodotto ordinato
	Prezzo di vendita = prezzo fornitore + 15%
*/
create or replace function gestione_ordine_consegnato()
returns trigger as $$
begin
	update vende v
	set quantita_disponibile = quantita_disponibile + new.quantita_prodotto
	where v.codice_prodotto = new.codice_prodotto and v.codice_negozio = new.codice_negozio;
	
	-- se non e' stato trovato il record da aggiornare viene inserito
	if not found then 
		insert into vende(quantita_disponibile,prezzo_prodotto,codice_prodotto,codice_negozio)
		values (new.quantita_prodotto,new.prezzo_prodotto * 1.15,new.codice_prodotto,new.codice_negozio);
	end if;
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_ordine_consegnato
	after update of stato on ordine
	for each row
	when (old.stato = 'confermato' and new.stato = 'consegnato')
	execute function gestione_ordine_consegnato();
	

/*
Quando lo stato passa da confermato a annullato, la quantità di 
prodotto ordinata viene automaticamente riaggiunta alla quantità disponibile del fornitore.
*/
create or replace function gestione_ordine_annullato()
returns trigger as $$
begin
	update fornisce f
	set quantita_disponibile = quantita_disponibile + new.quantita_prodotto
	where f.codice_prodotto = new.codice_prodotto and f.iva_fornitore = new.iva_fornitore;
	
	return new;
end;
$$ language plpgsql;

create or replace trigger TR_ordine_annullato
	after update of stato on ordine
	for each row
	when (old.stato = 'confermato' and new.stato = 'annullato')
	execute function gestione_ordine_annullato();

--Impedisce l'eliminazione di un ordine non ancora consegnato
create or replace function ordine_BD()
returns trigger as $$
begin
	if old.stato = 'confermato' then
		raise exception 'Gli ordini non consegnati o annullati non possono essere eliminati';
	end if;
	return old;
end;
$$ language plpgsql;

create or replace trigger TR_ordine_BD
	before delete on ordine
	for each row
	execute function ordine_BD();

