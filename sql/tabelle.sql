create table utente (
	cf VARCHAR(16) primary key,
	nome VARCHAR(50) not null,
	cognome VARCHAR(50) not null,
	email VARCHAR(255) not null unique,
	password VARCHAR(255) not null
);

create table cliente (
	cf_utente VARCHAR(16) primary key references utente(cf) on update cascade on delete cascade
);

create table manager (
	cf_utente VARCHAR(16) primary key references utente(cf) on update cascade on delete cascade,
	data_assunzione DATE not null default current_date check(data_assunzione <= current_date)
);

create table negozio (
	codice VARCHAR(10) primary key,
	indirizzo VARCHAR(255) not null unique,
	responsabile VARCHAR(100) not null,
	attivo BOOLEAN not null default true,
	cf_manager VARCHAR(16) not null references manager(cf_utente) on update cascade on delete no action
);

create table orario (
	primary key(Giorno, Codice_Negozio),
	ora_apertura TIME not null default '09:00:00',
    ora_chiusura TIME not null default '20:00:00',
	giorno VARCHAR(10) check(
    	giorno IN ('lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica')
    ),
    codice_negozio VARCHAR(10) references negozio(codice) on update cascade on delete cascade
);

create table tessera_fedelta (
	numero INTEGER generated always as identity primary key,
	punti INTEGER not null default 0 check(punti >= 0), 
	data_richiesta DATE not null check(data_richiesta <= current_date),
	data_emissione DATE not null default current_date check(data_emissione <= current_date),
	cf_cliente VARCHAR(16) not null references cliente(cf_utente) on update cascade on delete cascade,
	codice_negozio VARCHAR(10) not null references negozio(codice) on update cascade on delete no action,
	unique(cf_cliente,codice_negozio)
);

create table tessera_fedelta_archivio (
	numero_tessera INTEGER primary key,
	data_richiesta DATE not null check(data_richiesta <= current_date),
	data_emissione DATE not null check(data_emissione <= current_date),
	codice_negozio VARCHAR(10) not null references negozio(codice) on update cascade on delete no action
);

create table prodotto (
	codice VARCHAR(10) primary key,
	nome VARCHAR(100) not null,
	descrizione TEXT not null
);

create table fattura (
	codice INTEGER generated always as identity primary key,
	data DATE not null default current_date check(data <= current_date),
	totale DECIMAL(10,2) not null check(totale >= 0),
	sconto_percentuale DECIMAL(5,2) not null default 0 check(sconto_percentuale >= 0 and sconto_percentuale <= 100),
	cf_cliente VARCHAR(16) references cliente(cf_utente) on update cascade on delete set null
);

create table riga_fattura (
	primary key(codice_fattura,codice_prodotto,codice_negozio), 
	quantita_prodotto INTEGER not null check(quantita_prodotto >= 1),
	prezzo_prodotto DECIMAL(10,2) not null check(prezzo_prodotto >= 0),
	codice_fattura INTEGER references fattura(codice) on update cascade on delete cascade,
	codice_prodotto VARCHAR(10) references prodotto(codice) on update cascade on delete no action,
	codice_negozio VARCHAR(10) references negozio(codice) on update cascade on delete no action
);

create table vende (
	primary key(codice_prodotto,codice_negozio),
	quantita_disponibile INTEGER not null default 0 check(quantita_disponibile >= 0),
	prezzo_prodotto DECIMAL(10,2) not null default 0 check(prezzo_prodotto >= 0),
	sconto_percentuale DECIMAL(5,2) not null default 0 check(sconto_percentuale >= 0 and sconto_percentuale <= 100),
	codice_prodotto VARCHAR(10) references prodotto(codice) on update cascade on delete cascade,
	codice_negozio VARCHAR(10) references negozio(codice) on update cascade on delete cascade
);

create table fornitore (
	iva VARCHAR(11) primary key,
	indirizzo VARCHAR(255) not null unique,
	attivo BOOLEAN not null default true,
	cf_manager VARCHAR(16) not null references manager(cf_utente) on update cascade on delete no action
);

create table fornisce (
	primary key(codice_prodotto,iva_fornitore),
	quantita_disponibile INTEGER not null default 0 check(quantita_disponibile >= 0),
	prezzo_prodotto DECIMAL(10,2) not null default 0 check(prezzo_prodotto >= 0),
	codice_prodotto VARCHAR(10) references prodotto(codice) on update cascade on delete cascade,
	iva_fornitore VARCHAR(11) references fornitore(iva) on update cascade on delete cascade
);

create table ordine (
	numero INTEGER generated always as identity primary key,
	quantita_prodotto INTEGER not null check(quantita_prodotto >= 1),
	prezzo_prodotto DECIMAL(10,2) not null check(prezzo_prodotto >= 0),
	stato VARCHAR(15) not null check(stato IN ('confermato','annullato','consegnato')), 
	data_consegna DATE,
	iva_fornitore VARCHAR(11) not null references fornitore(iva) on update cascade on delete no action,
	codice_prodotto VARCHAR(10) not null references prodotto(codice) on update cascade on delete no action,
	codice_negozio VARCHAR(10) not null references negozio(codice) on update cascade on delete no action
);
