# Server-Systeem
02. Ruumide broneerimine
Projekti ülesanne aines Võrgurakendused I

Ülesande kirjeldus

Ülesandeks on luua lihtne ruumide broneerimise süsteem, kus registreeritud kasutaja saab vaadata olemasolevaid ruume ning sisestada broneeringuid

Lisatingimused

Kasutaja saab registreerida endale uue konto
Kasutaja saab end sisse logida
Ruumid sisestatakse otse andmebaasi, selle jaoks ei ole liidest vaja
Lahendus

Registreeritud kasutaja ja admin saavad näha kõiki ruume ühe nimekirjana.
Ruumi kirjel klikkides avaneb ruumi detailvaade.
Detailvaates näeb tavakasutaja ruumi kirjeldust ja broneeringute nimekirja (algus, lõpp) ning admin saab olemasolevaid breoneeringuid kustutada.
Samas on ka broneeringu tegemise vorm. Broneering kinnitatakse kui see ei kattu ühegi varasema broneeringuga
Väljade vormingu kontroll ei ole oluline, eeldame et broneeringu ajad sisestatakse alati kindlas formaadis (n. YYYY-MM-DD HH:mm)

Märkused

Andmebaasis võiks olla järgmised tabelid:

Kasutajate tabel: kasutaja_id, kasutajanimi, parool
Ruumide tabel: ruumi_id, ruumi_nimi (siia tabelisse võib lisada andmed käsitsi)
Broneeringute tabel: bronni_id, ruumi_id, kasutaja_id, bronni_algus, bronni_lõpp

Näide

1. Ruumide nimekiri

Ruumi nimetus	
A321	Broneerima...
A322	Broneerima...
A323	Broneerima...
2. Ruumi detailvaade

*	
Ruumi nimetus	A321
Lisa oma broneering:

[ 2016-01-01 00:00  ] – [ 2016-01-01 01:00  ]  [broneeri ruum]
Olemasolevad broneeringud:

Broneeringu algus	Broneeringu lõpp
2016-03-01 00:00	2016-03-01 01:00
2016-03-01 01:00	2016-03-01 02:00
2016-03-01 02:00	2016-03-01 03:00
3. Broneeringu ebaõnnestumine

Broneerimine ebaõnnestus: valitud ajal on ruum juba broneeritud
[tagasi ruumide lehele]
admin: marioadmin
parool: marioadmin
