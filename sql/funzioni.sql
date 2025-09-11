-- Restituisce una tabella che contiene gli sconti disponibili per un determinato cliente
create or replace function sconti_disponibili(codice_fiscale_cliente VARCHAR(16))
returns table(costo_punti INTEGER,sconto_percentuale DECIMAL(5,2)) as $$
declare
	punti_cliente INTEGER := 0;
begin
	select tf.punti into punti_cliente
	from tessera_fedelta tf
	where tf.cf_cliente = codice_fiscale_cliente; 
	
	return query
	select s.costo_punti, s.sconto_percentuale
	from (
		values 
			(100,5::DECIMAL(5,2)),
			(200,15::DECIMAL(5,2)),
			(300,30::DECIMAL(5,2)) 
	) as s(costo_punti,sconto_percentuale)
	where punti_cliente >= s.costo_punti
	order by s.costo_punti;
end;
$$ language plpgsql;

create or replace function is_attivo_negozio(codice_negozio VARCHAR(10))
returns BOOLEAN as $$ 
declare 
	stato_negozio BOOLEAN;
begin
	select attivo into stato_negozio
	from negozio
	where codice = codice_negozio;
	return stato_negozio;
end;
$$ language plpgsql;


/*
Restituisce una lista dei clienti che si sono tesserati in un determinato negozio. 
*/
create or replace function get_tesserati_negozio(negozio VARCHAR(10))
returns TABLE (
	cf VARCHAR(16),
	nome VARCHAR(50),
	cognome VARCHAR(50),
	email VARCHAR(255)
) as $$ 
begin
	return query
	select u.cf, u.nome, u.cognome, u.email
	from tessera_fedelta t join utente u on t.cf_cliente = u.cf
	where t.codice_negozio = negozio;
end;
$$ language plpgsql;

/*
Restituisce la lista di ordini ricevuti da un fornitore.     
*/
create or replace function get_ordini_fornitore(fornitore VARCHAR(11))
returns TABLE (
	numero INTEGER,
	quantita_prodotto INTEGER,
	prezzo_prodotto DECIMAL(10,2),
	data_consegna DATE,
	indirizzo_negozio VARCHAR(255),
	nome_prodotto VARCHAR(100),
	descrizione_prodotto TEXT
) as $$ 
begin
	return query
	select o.numero, o.quantita_prodotto, o.prezzo_prodotto, o.data_consegna, n.indirizzo, p.nome, p.descrizione
	from ordine o 
		join negozio n on o.codice_negozio = n.codice
		join prodotto p on o.codice_prodotto = p.codice	
	where o.iva_fornitore = fornitore;
end;
$$ language plpgsql;

/*
Elenco aggiornato dei clienti che hanno una tessera fedeltà con un saldo punti superiore a 300 punti.
*/
create view saldo_punti_clienti as
select
	u.nome,
	u.cognome,
	u.email,
	u.cf
from utente u join tessera_fedelta tf on u.cf = tf.cf_cliente	
where tf.punti > 300;


	