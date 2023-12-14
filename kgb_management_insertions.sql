INSERT INTO Admin (
    admin_firstname,
    admin_lastname,
    admin_email,
    admin_password
) VALUES (
    'Lucian',
    'Mclean',
    'lucian-mclean@email.com',
    '$2a$12$UvM2bsv.lLA25L2N7Oc78uKuII1KI9uDnJ3//zI.HcEiVMGBCy0ne'
    -- Password : N706{XK#2n-5!nSrbj,K
), (
    'Shania',
    'Wood',
    'shaniawood@email.com',
    '$2a$12$t9RJW0oBPq4OAvxliUp6Pu3iM2GfCTilPhFTwmeUiaYDAifywLlvC'
    -- Password : s<tRtP,(X5=so-5171OB
), (
    'Tianna',
    'Rangel',
    'tianna.rangel@email.com',
    '$2a$12$2IUyHAFk4.37amxzht8dZuvZyctu.3blKAb3QmW.JtTXD0uZsKaH6'
    -- Passwords : XI2roscS}[@@gSO980,1
);

INSERT INTO Specialty (
    specialty_name
) VALUES (
    'shooter'
), (
    'support'
), (
    'discretion'
), (
    'diplomacy'
), (
    'seduction'
), (
    'engineering'
), (
    'hacking'
);

INSERT INTO Mission_status (
    mission_status_name
) VALUES (
    'in preparation'
), (
    'in progress'
), (
    'finished'
), (
    'failure'
);

INSERT INTO Mission_type (
    mission_type_name
) VALUES (
    'assassination'
), (
    'cleaning'
), (
    'undercover'
), (
    'exfiltration'
), (
    'monitoring'
), (
    'intelligence'
), (
    'sabotage'
), (
    'manipulation'
), (
    'kidnapping'
);

INSERT INTO Hideout_type (
    hideout_type_name
) VALUES (
    'hotel room'
), (
    'villa'
), (
    'high mountain chalet'
), (
    'private domain'
), (
    'fitted box'
), (
    'bunker'
), (
    'unmarked vehicle'
);

INSERT INTO Agent (
    agent_code,
    agent_firstname,
    agent_lastname,
    agent_birthday,
    agent_nationality
) VALUES (
    '001',
    'Tana',
    'Dufner',
    '1981-01-01 01:01:00',
    'Russia'
), (
    '002',
    'Daniel',
    'Herek',
    '1982-02-02 02:02:00',
    'Russia'
), (
    '003',
    'Ronnie',
    'Snowdon',
    '1983-03-03 03:03:00',
    'Turkmenistan'
), (
    '004',
    'Arcadio',
    'Carli',
    '1984-04-04 04:04:00',
    'Belarus'
), (
    '005',
    'Cecilia',
    'Winchenbach',
    '1985-05-05 05:05:00',
    'Russia'
), (
    '006',
    'Loida',
    'Usilton',
    '1986-06-06 06:06:00',
    'Czech Republic'
), (
    '007',
    'Cesare',
    'Benigno',
    '1987-07-07 07:07:00',
    'Estonia'
), (
    '008',
    'Norah Croley',
    'Name-Agent8',
    '1988-08-08 08:08:00',
    'Romania'
), (
    '009',
    'Jean',
    'Wareing',
    '1989-09-09 09:09:00',
    'Slovenia'
), (
    '010',
    'Caeden',
    'Issac',
    '1990-10-10 10:10:00',
    'Belarus'
), (
    '011',
    'Keeley',
    'McHugh',
    '1991-11-11 11:11:00',
    'Estonia'
), (
    '012',
    'Leeroy',
    'Harrington',
    '1992-12-12 12:12:00',
    'Moldova'
), (
    '013',
    'Emanuel',
    'Layher',
    '1993-01-01 01:01:00',
    'Kazakhstan'
), (
    '014',
    'Kalman',
    'Bakst',
    '1995-02-02 02:02:00',
    'Belarus'
), (
    '015',
    'Josefa',
    'Kerschner',
    '1996-04-04 04:04:00',
    'Poland'
), (
    '016',
    'Joel',
    'Sanderrman',
    '1997-04-04 04:04:00',
    'Russia'
), (
    '017',
    'Brinton',
    'Edgington',
    '1998-05-05 05:05:00',
    'Slovakia'
), (
    '018',
    'Kaelan',
    'Bardeen',
    '1999-06-06 06:06:00',
    'Russia'
), (
    '019',
    'Amani',
    'Kinker',
    '1999-06-06 06:06:00',
    'Russia'
), (
    '020',
    'Anna',
    'Pavlat',
    '1999-06-06 06:06:00',
    'Slovenia'
), (
    '021',
    'Emmanuelle',
    'Lozeau',
    '1999-06-06 06:06:00',
    'Iran'
), (
    '022',
    'Denia',
    'Freeney',
    '1999-06-06 06:06:00',
    'Irak'
), (
    '023',
    'Micah',
    'Kordich',
    '1999-06-06 06:06:00',
    'Kazakhstan'
), (
    '024',
    'Jefrey',
    'Burnison',
    '1999-06-06 06:06:00',
    'Ouzbekistan'
);

INSERT INTO Agent_Specialty (
    agent_uuid,
    specialty_id
) VALUES (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '001'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '001'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'discretion')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '002'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'seduction')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '002'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '003'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '003'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'diplomacy')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '004'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '005'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'hacking')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '006'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '006'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'hacking')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '007'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '007'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'seduction')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '007'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'discretion')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '008'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'diplomacy')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '009'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '010'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'hacking')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '011'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '011'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'discretion')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '012'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '013'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'discretion')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '013'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'diplomacy')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '014'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'hacking')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '015'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '016'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '017'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '017'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '018'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'seduction')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '019'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '019'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'discretion')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '020'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'seduction')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '021'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '022'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '023'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'hacking')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '023'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'discretion')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '023'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'seduction')
), (
    (SELECT agent_uuid FROM Agent WHERE agent_code = '024'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'diplomacy')
);

INSERT INTO Contact (
    contact_code_name,
    contact_firstname,
    contact_lastname,
    contact_birthday,
    contact_nationality
) VALUES (
    'Lame Eagle',
    'Martine',
    'Espeland',
    '1974-01-01 01:01:00',
    'USA'
), (
    'Amazing Hammer',
    'Adam',
    'Buczynski',
    '1975-02-01 02:01:00',
    'Hungary'
), (
    'Brown Proton',
    'Paulina',
    'Kronholm',
    '1976-03-01 03:01:00',
    'Denmark'
), (
    'Purple Chariot',
    'Aphrodite',
    'Presley',
    '1977-04-01 04:01:00',
    'France'
), (
    'Frugal Bulldog',
    'Christel',
    'Clowser',
    '1978-05-01 05:01:00',
    'Estonia'
), (
    'Plastic Cameo',
    'Iris',
    'Proscia',
    '1979-06-01 06:01:00',
    'Italy'
), (
    'Twilight Phantom',
    'Cornelia',
    'Bertolami',
    '1980-07-01 07:01:00',
    'Belgium'
), (
    'Vicious Volcano',
    'Izis',
    'Zabala',
    '1981-07-01 08:01:00',
    'Albania'
), (
    'Rapid Bagpipe',
    'Samya',
    'Longbottom',
    '1982-08-01 09:01:00',
    'Armenia'
), (
    'Impish Shark',
    'Raelene',
    'Sheron',
    '1983-09-01 10:01:00',
    'Austria'
), (
    'Swift Demon',
    'Arlon',
    'Prust',
    '1984-10-01 10:01:00',
    'Belarus'
), (
    'Canine Geyser',
    'Hermon',
    'Javins',
    '1985-11-01 11:01:00',
    'Bulgaria'
), (
    'Steel Swordfish',
    'Alida',
    'Krumwiede',
    '1986-12-01 12:01:00',
    'Czech Republic'
), (
    'Active Tinkerbell',
    'Zev',
    'Minyard',
    '1987-01-01 13:01:00',
    'Croatia'
), (
    'Innocent Hawk',
    'Juanita',
    'Ruth',
    '1988-02-01 14:01:00',
    'Germany'
), (
    'Salty Witness',
    'Jacobi',
    'Ticknor',
    '1989-03-01 15:01:00',
    'Romania'
), (
    'Hollow Flamingo',
    'Manu',
    'Infante',
    '1990-04-01 16:01:00',
    'Greece'
), (
    'Hungry Rainbow',
    'Cynthia',
    'Baumhover',
    '1991-05-01 17:01:00',
    'Turkey'
), (
    'Yawning Sun',
    'Maura',
    'Gronowski',
    '1992-06-01 18:01:00',
    'Russia'
), (
    'Purple Packer',
    'Lew',
    'Bobola',
    '1993-07-01 19:01:00',
    'Croatia'
), (
    'Digital Prodigy',
    'Magdalena',
    'Pavlas',
    '1994-08-01 20:01:00',
    'Germany'
), (
    'Crisp Carbine',
    'Rhett',
    'Gentle',
    '1995-09-01 21:01:00',
    'Romania'
), (
    'Clumsy Tiger',
    'Monica',
    'Bitto',
    '1996-10-01 22:01:00',
    'Belgium'
), (
    'Brave Balboa',
    'Rebel',
    'Mathia',
    '1997-11-01 23:01:00',
    'Denmark'
), (
    'Feline Behemoth',
    'Rosa',
    'Kindberg',
    '1998-12-01 01:01:00',
    'Albania'
), (
    'Arid Lancer',
    'Kord',
    'Furse',
    '1999-01-01 02:01:00',
    'Austria'
);

INSERT INTO Target (
    target_code_name,
    target_firstname,
    target_lastname,
    target_birthday,
    target_nationality
) VALUES (
    'Heavy Heart',
    'Florence',
    'Eckes',
    '1977-01-01 01:00:00',
    'USA'
), (
    'Serious Toupee',
    'Aubry',
    'Rackliff',
    '1978-02-02 02:00:00',
    'Denmark'
), (
    'Fire Phoenix',
    'Katja',
    'Hartlaub',
    '1979-03-03 03:00:00',
    'France'
), (
    'Firm Arrow',
    'Beau',
    'Servant',
    '1980-04-04 04:00:00',
    'Italy'
), (
    'Grim Pawn',
    'Margareta',
    'Franck',
    '1981-05-05 05:00:00',
    'USA'
), (
    'Basic Surgeon',
    'Kervin',
    'Dryden',
    '1982-06-06 06:00:00',
    'Turkey'
), (
    'Precious Spectator',
    'Jack',
    'Heineman',
    '1983-07-07 07:00:00',
    'Romania'
), (
    'Faint Lizard',
    'Noa',
    'Gaut',
    '1984-08-08 08:00:00',
    'Greece'
), (
    'Blank Fox',
    'Aissa',
    'Odiorne',
    '1985-09-09 09:00:00',
    'Germany'
), (
    'Agile Dasher',
    'Ames',
    'Kay',
    '1986-10-10 10:00:00',
    'Czech Republic'
), (
    'Bulky Grandpa',
    'Nola',
    'Morrisroe',
    '1987-11-11 11:00:00',
    'Croatia'
), (
    'Amazing Mercury',
    'Bonney',
    'Stott',
    '1988-12-12 12:00:00',
    'Bulgaria'
), (
    'Fatal Thunder',
    'Alan',
    'Buchannon',
    '1960-01-13 13:00:00',
    'Belarus'
), (
    'Warm Falcon',
    'Pedro',
    'Ennes',
    '1961-02-14 14:00:00',
    'Austria'
), (
    'Silver Dragonfly',
    'Tora',
    'Golphin',
    '1962-03-15 15:00:00',
    'Armenia'
), (
    'Equal Behemoth',
    'Severiano',
    'Bartolini',
    '1963-04-16 16:00:00',
    'Albania'
), (
    'Early Gambit',
    'Minda',
    'Lindgren',
    '1964-05-17 17:00:00',
    'Belgium'
), (
    'Sad Ribbon',
    'Georgina',
    'Stuber',
    '1965-06-18 18:00:00',
    'Russia'
), (
    'Coarse Pebble',
    'Conley',
    'Mountcastle',
    '1966-07-19 19:00:00',
    'Estonia'
), (
    'Brief Star',
    'Kristopher',
    'Jutila',
    '1967-08-20 20:00:00',
    'Bulgaria'
), (
    'Pink Eye',
    'Robert',
    'Halfmann',
    '1968-09-21 21:00:00',
    'Croatia'
), (
    'Mellow Lightning',
    'Vito',
    'Basey',
    '1969-10-22 22:00:00',
    'Romania'
);

INSERT INTO Hideout (
    hideout_code_name,
    hideout_address,
    hideout_country,
    hideout_type
) VALUES (
    'Urban Eclipse',
    '577 Harvest Lane, Bakersfield, California(CA), 93307',
    'USA',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'hotel room')
), (
    'Meaningful Street',
    'Metsa 38, Rannaküla',
    'Estonia',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'villa')
), (
    'Western Moon',
    'Kis Diófa u. 94, Orfalu',
    'Hungary',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'high mountain chalet')
), (
    'Alert Citadel',
    'Gartnervænget 44, Vipperød',
    'Denmark',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'private domain')
), (
    'Sunday’s Jupiter',
    '1935 Khale Street, Charleston, South Carolina(SC), 29405',
    'USA',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'fitted box')
), (
    'Golden Harpie',
    '46 Square de la Couronne, PANTIN, Île-de-France(IL), 93500',
    'France',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'bunker')
), (
    'Strong Crystal',
    'Via Vipacco 143, Tergu, Sassari(SS), 07030',
    'Italy',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'unmarked vehicle')
), (
    'Jolly Hunter',
    'Populierenstraat 366, Aalbeke',
    'Belgium',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'hotel room')
), (
    'Lantern Subtle',
    '955 Heavner Court, Altoona, Iowa(IA), 50009',
    'USA',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'villa')
), (
    'Flat Angler',
    'Fasanenstrasse 55, Hamburg Osdorf, Hamburg(HH), 22549',
    'Germany',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'high mountain chalet')
), (
    'Feisty Supernova',
    'Rruga Petro Nini Luarasi, Perballe Kreheri I Arte, Tirana',
    'Albania',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'private domain')
), (
    'Candid Carbine',
    '28 bul. Dragan Tsankov, Гара Пионер, Sofia',
    'Bulgaria',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'fitted box')
), (
    'Happy Beehive',
    'STR. MITROPOLIEI nr. 16, SIBIU',
    'Romania',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'bunker')
), (
    'Major Frostbite',
    '0010, Pushkini St. 40; Nor Aresh, 35th St, Yerevan',
    'Armenia',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'unmarked vehicle')
), (
    'Icky Venus',
    'Vijenac Ivana Meštrovića bb, 31000, Osijek',
    'Croatia',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'hotel room')
), (
    'Impure Centurion',
    'Nové Město 1440, Hnevkovice U Ledce Nad Sázavou',
    'Czech republic',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'villa')
), (
    'Violet Packer',
    '73 Αδαμάντιου Κοραή, Vyronas',
    'Greece',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'high mountain chalet')
), (
    'Needy Lyric',
    'ATATÜRK ORGANİZE SANAYİ BÖLGESİ 10024. S N 4, Çiğli',
    'Turkey',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'high mountain chalet')
), (
    'Warm Templer',
    'Wiedner Hauptstrasse 90, HÖtschdorf',
    'Austria',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'fitted box')
), (
    'Quiet Cobra',
    'Utes / Kaminskoy Ul., bld. 104, Baranovichi',
    'Belarus',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'bunker')
), (
    'Lonely Lizard',
    'Rruga Borodin Mitharja, Prane Shkolles Pedagogjike, Elbasan',
    'Albania',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'unmarked vehicle')
), (
    'Bleak Lancer',
    'Turgeneva, bld. 6, Vladivostok, Primorskiy kray,',
    'Russia',
    (SELECT hideout_type_id FROM Hideout_type WHERE hideout_type_name = 'hotel room')
);

INSERT INTO Mission (
    mission_code_name,
    mission_title,
    mission_description,
    mission_country,
    mission_type,
    mission_specialty,
    mission_status,
    mission_start_date,
    mission_end_date
) VALUES (
    'Mission Alpha',
    'Title mission Alpha',
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nisl pretium fusce id velit ut tortor pretium viverra suspendisse. Donec ac odio tempor orci. Luctus venenatis lectus magna fringilla urna porttitor rhoncus dolor. Malesuada bibendum arcu vitae elementum. Lobortis mattis aliquam faucibus purus in massa tempor. Aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed. Morbi blandit cursus risus at ultrices. Laoreet suspendisse interdum consectetur libero id. Laoreet id donec ultrices tincidunt arcu non sodales. Sed turpis tincidunt id aliquet. Pulvinar proin gravida hendrerit lectus. Tellus at urna condimentum mattis pellentesque id nibh.',
    'USA',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'assassination'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2023-09-30 00:00:00',
    '2024-01-01 00:00:00'
), (
    'Mission Beta',
    'Title mission Beta',
    'Pretium viverra suspendisse potenti nullam ac tortor vitae purus. Lectus nulla at volutpat diam. Facilisis sed odio morbi quis commodo. Amet cursus sit amet dictum sit amet justo donec enim. Quam vulputate dignissim suspendisse in est ante in nibh mauris.',
    'France',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'cleaning'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in progress'),
    '2023-08-01 06:00:00',
    '2024-02-01 20:00:00'
), (
    'Mission Gamma',
    'Title mission Gamma',
    'Elit sed vulputate mi sit amet. Donec adipiscing tristique risus nec feugiat in fermentum posuere urna. Vestibulum lectus mauris ultrices eros in cursus. Ut eu sem integer vitae justo. Hendrerit dolor magna eget est lorem ipsum dolor. Dui nunc mattis enim ut tellus. Lectus urna duis convallis convallis tellus id interdum velit. Tincidunt augue interdum velit euismod. Pretium fusce id velit ut. Cursus euismod quis viverra nibh.',
    'Bulgaria',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'intelligence'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'diplomacy'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-01-01 04:30:00',
    '2024-06-15 23:00:00'
), (
    'Mission Delta',
    'Title mission Delta',
    'Turpis tincidunt id aliquet risus feugiat in ante metus. Vitae auctor eu augue ut lectus arcu. Mattis vulputate enim nulla aliquet porttitor. Congue eu consequat ac felis donec et. Sit amet porttitor eget dolor. Sagittis eu volutpat odio facilisis mauris sit amet massa. Nisl nisi scelerisque eu ultrices vitae auctor eu augue. Nullam eget felis eget nunc. Et sollicitudin ac orci phasellus egestas tellus. Tempus iaculis urna id volutpat lacus laoreet non curabitur. Urna molestie at elementum eu facilisis sed odio. Nec ullamcorper sit amet risus nullam eget felis eget.',
    'Denmark',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'intelligence'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'failure'),
    '2023-03-08 06:00:00',
    '2023-08-02 06:00:00'
), (
    'Mission Epsilon',
    'Title mission Epsilon',
    'Tincidunt lobortis feugiat vivamus at augue eget arcu dictum. Imperdiet nulla malesuada pellentesque elit eget gravida cum sociis natoque. Felis eget nunc lobortis mattis aliquam faucibus. Elementum pulvinar etiam non quam lacus suspendisse. Tortor posuere ac ut consequat semper viverra nam libero. Volutpat sed cras ornare arcu dui vivamus arcu felis. Egestas quis ipsum suspendisse ultrices gravida dictum. Dignissim enim sit amet venenatis urna cursus. Amet mauris commodo quis imperdiet massa tincidunt. Proin nibh nisl condimentum id venenatis a condimentum vitae sapien. Laoreet id donec ultrices tincidunt.',
    'Russia',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'assassination'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'finished'),
    '2023-01-09 11:00:00',
    '2023-03-04 15:00:00'
), (
    'Mission Zeta',
    'Title mission Zeta',
    'Neque laoreet suspendisse interdum consectetur. Platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Feugiat in fermentum posuere urna. Leo a diam sollicitudin tempor. Et magnis dis parturient montes nascetur ridiculus mus. Id nibh tortor id aliquet lectus proin nibh. Amet consectetur adipiscing elit duis. Pharetra et ultrices neque ornare aenean euismod.',
    'Albania',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'exfiltration'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'discretion'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-05-28 08:15:00',
    '2024-07-07 13:00:00'
), (
    'Mission Eta',
    'Title mission Eta',
    'Sed odio morbi quis commodo odio aenean sed. Eget mauris pharetra et ultrices neque ornare aenean euismod. Hac habitasse platea dictumst quisque. Risus pretium quam vulputate dignissim suspendisse in est ante. Amet facilisis magna etiam tempor orci. Pellentesque adipiscing commodo elit at imperdiet dui. Duis at consectetur lorem donec.',
    'Greece',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'undercover'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'diplomacy'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in progress'),
    '2023-09-08 02:00:00',
    '2023-09-29 00:00:00'
), (
    'Mission Theta',
    'Title mission Theta',
    'Id cursus metus aliquam eleifend mi. Tristique senectus et netus et malesuada fames ac. Facilisi cras fermentum odio eu feugiat pretium nibh ipsum. Sit amet nisl suscipit adipiscing bibendum est ultricies integer quis. Tristique senectus et netus et malesuada fames ac. Elit pellentesque habitant morbi tristique senectus. Egestas pretium aenean pharetra magna ac placerat vestibulum lectus. Commodo ullamcorper a lacus vestibulum sed arcu non odio euismod. ',
    'Germany',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'manipulation'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'diplomacy'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'finished'),
    '2023-02-14 08:00:00',
    '2024-04-01 19:00:00'
), (
    'Mission Iota',
    'Title mission Iota',
    'Velit laoreet id donec ultrices tincidunt arcu non. Lectus mauris ultrices eros in cursus. Malesuada pellentesque elit eget gravida cum sociis natoque penatibus. Faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam. Sagittis orci a scelerisque purus. Auctor urna nunc id cursus metus aliquam eleifend mi in. Lectus vestibulum mattis ullamcorper velit sed ullamcorper.',
    'Romania',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'intelligence'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in progress'),
    '2023-08-10 00:00:00',
    '2023-12-02 23:30:00'
), (
    'Mission Kappa',
    'Title mission Kappa',
    'Malesuada fames ac turpis egestas. In fermentum et sollicitudin ac orci phasellus egestas. Et egestas quis ipsum suspendisse. Accumsan lacus vel facilisis volutpat. Enim sit amet venenatis urna cursus eget nunc scelerisque viverra. Pellentesque nec nam aliquam sem. Turpis nunc eget lorem dolor sed viverra ipsum nunc aliquet.',
    'Belarus',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'exfiltration'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-01-02 08:30:00',
    '2024-08-01 13:00:00'
), (
    'Mission Lambda',
    'Title mission Lambda',
    'Urna et pharetra pharetra massa massa ultricies. Turpis cursus in hac habitasse. Et leo duis ut diam quam nulla porttitor massa id. Ac turpis egestas maecenas pharetra convallis posuere morbi leo. Sit amet porttitor eget dolor morbi non arcu risus. Amet commodo nulla facilisi nullam. Pharetra pharetra massa massa ultricies. In fermentum et sollicitudin ac orci phasellus. Ac tortor vitae purus faucibus ornare suspendisse sed nisi.',
    'Turkey',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'intelligence'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'hacking'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-02-15 07:00:00',
    '2024-02-28 07:00:00'
), (
    'Mission Mu',
    'Title mission Mu',
    'Egestas sed sed risus pretium quam vulputate dignissim suspendisse in. Ac placerat vestibulum lectus mauris. Eu turpis egestas pretium aenean pharetra magna ac. Ut eu sem integer vitae justo eget magna fermentum iaculis. Sit amet massa vitae tortor condimentum lacinia. Risus nec feugiat in fermentum. Phasellus vestibulum lorem sed risus ultricies. Sit amet cursus sit amet dictum sit amet justo. In nulla posuere sollicitudin aliquam ultrices sagittis orci a.',
    'Czech Republic',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'monitoring'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'hacking'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in progress'),
    '2023-06-08 08:15:00',
    '2023-09-18 22:00:00'
), (
    'Mission Nu',
    'Title mission Nu',
    'Pulvinar pellentesque habitant morbi tristique senectus et. Libero volutpat sed cras ornare. Sed euismod nisi porta lorem mollis aliquam ut. Rutrum tellus pellentesque eu tincidunt tortor. Morbi tristique senectus et netus. Fringilla urna porttitor rhoncus dolor. Eget lorem dolor sed viverra. Egestas sed sed risus pretium.',
    'Austria',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'undercover'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'seduction'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'finished'),
    '2023-09-08 06:00:00',
    '2023-10-02 02:00:00'
), (
    'Mission Xi',
    'Title mission Xi',
    'Vitae tortor condimentum lacinia quis vel eros. Erat velit scelerisque in dictum non. Lorem dolor sed viverra ipsum nunc. Nunc sed augue lacus viverra vitae. Pulvinar proin gravida hendrerit lectus. Phasellus vestibulum lorem sed risus ultricies tristique nulla. Vitae tortor condimentum lacinia quis vel eros donec ac.',
    'Armenia',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'kidnapping'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'discretion'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-03-01 04:00:00',
    '2024-04-01 05:00:00'
), (
    'Mission Omicron',
    'Title mission Omicron',
    'In iaculis nunc sed augue lacus viverra vitae. Elit eget gravida cum sociis natoque. Orci phasellus egestas tellus rutrum tellus pellentesque eu tincidunt. Placerat duis ultricies lacus sed turpis. Et sollicitudin ac orci phasellus egestas tellus rutrum. Nunc faucibus a pellentesque sit amet porttitor eget. Tempus iaculis urna id volutpat. Magna fermentum iaculis eu non diam phasellus vestibulum lorem sed. Pulvinar mattis nunc sed blandit libero. Lacus sed turpis tincidunt id aliquet. Purus faucibus ornare suspendisse sed nisi lacus.',
    'Bulgaria',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'manipulation'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'diplomacy'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-08-08 02:00:00',
    '2025-05-01 04:30:00'
), (
    'Mission Pi',
    'Title mission Pi',
    'Ullamcorper malesuada proin libero nunc consequat interdum. Bibendum enim facilisis gravida neque. Diam in arcu cursus euismod quis viverra nibh cras pulvinar. Libero volutpat sed cras ornare arcu. Ultrices tincidunt arcu non sodales neque sodales. Posuere morbi leo urna molestie at elementum eu facilisis. Vestibulum lectus mauris ultrices eros in cursus turpis. Sit amet nisl suscipit adipiscing bibendum.',
    'Croatia',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'sabotage'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-04-23 05:30:00',
    '2023-09-30 00:00:00'
), (
    'Mission Rho',
    'Title mission Rho',
    'Consectetur adipiscing elit duis tristique sollicitudin nibh sit amet. Pellentesque habitant morbi tristique senectus. Cum sociis natoque penatibus et. Ut enim blandit volutpat maecenas volutpat. Tincidunt praesent semper feugiat nibh sed pulvinar. Posuere lorem ipsum dolor sit amet. Nisi vitae suscipit tellus mauris a. Hendrerit dolor magna eget est lorem ipsum dolor sit. Ultricies integer quis auctor elit sed.',
    'Belgium',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'assassination'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-07-01 00:00:00',
    '2024-08-17 23:59:00'
), (
    'Mission Sigma',
    'Title mission Sigma',
    'Duis ut diam quam nulla porttitor massa id neque aliquam. Dictum varius duis at consectetur lorem donec. Turpis massa tincidunt dui ut ornare lectus. Elit ut aliquam purus sit amet. Mi tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Aliquam vestibulum morbi blandit cursus risus at ultrices mi. Pretium lectus quam id leo in vitae turpis massa. Nulla facilisi morbi tempus iaculis. Placerat duis ultricies lacus sed turpis tincidunt id aliquet. ',
    'Armenia',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'intelligence'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'hacking'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'in preparation'),
    '2024-10-01 04:00:00',
    '2024-11-04 12:30:00'
), (
    'Mission Tau',
    'Title mission Tau',
    'Nibh tellus molestie nunc non blandit. Tempus egestas sed sed risus. Lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi tincidunt. Tellus in hac habitasse platea dictumst vestibulum rhoncus est pellentesque. Et magnis dis parturient montes nascetur ridiculus. Fames ac turpis egestas maecenas pharetra. Blandit cursus risus at ultrices mi tempus imperdiet nulla.',
    'Croatia',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'assassination'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'shooter'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'finished'),
    '2023-02-01 06:00:00',
    '2023-02-08 16:00:00'
), (
    'Mission Upsilon',
    'Title mission Upsilon',
    'Risus commodo viverra maecenas accumsan lacus vel facilisis. Urna condimentum mattis pellentesque id nibh tortor id. Dui sapien eget mi proin sed libero. Tristique et egestas quis ipsum. Platea dictumst quisque sagittis purus sit amet volutpat consequat mauris. Magnis dis parturient montes nascetur ridiculus mus mauris vitae ultricies. Sed odio morbi quis commodo odio aenean sed. Libero nunc consequat interdum varius sit amet mattis.',
    'Albania',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'monitoring'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'support'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'failure'),
    '2023-03-30 02:00:00',
    '2023-07-21 13:30:00'
), (
    'Mission Phi',
    'Title mission Phi',
    'In mollis nunc sed id semper risus. Mauris a diam maecenas sed enim. Semper feugiat nibh sed pulvinar proin. Etiam erat velit scelerisque in dictum non consectetur a. Quam vulputate dignissim suspendisse in est ante in. Sed tempus urna et pharetra pharetra massa massa ultricies mi.',
    'Estonia',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'exfiltration'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'engineering'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'failure'),
    '2023-03-10 12:00:00',
    '2023-04-10 12:00:00'
), (
    'Mission Chi',
    'Title mission Chi',
    'Non diam phasellus vestibulum lorem sed risus ultricies tristique. A scelerisque purus semper eget duis at tellus at. Auctor augue mauris augue neque gravida in fermentum. At erat pellentesque adipiscing commodo elit.',
    'Turkey',
    (SELECT mission_type_id FROM Mission_type WHERE mission_type_name = 'assassination'),
    (SELECT specialty_id FROM Specialty WHERE specialty_name = 'seduction'),
    (SELECT mission_status_id FROM Mission_status WHERE mission_status_name = 'finished'),
    '2023-03-11 00:00:00',
    '2024-02-25 01:30:00'
);

INSERT INTO Mission_Contact (
    mission_uuid,
    contact_uuid
) VALUES (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Alpha'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Lame Eagle')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Beta'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Purple Chariot')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Gamma'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Amazing Hammer')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Delta'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Brown Proton')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Delta'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Brave Balboa')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Epsilon'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Yawning Sun')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Zeta'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Vicious Volcano')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Zeta'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Feline Behemoth')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Eta'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Hollow Flamingo')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Theta'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Digital Prodigy')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Iota'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Salty Witness')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Kappa'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Swift Demon')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Lambda'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Hungry Rainbow')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Mu'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Steel Swordfish')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Nu'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Arid Lancer')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Nu'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Impish Shark')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Xi'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Rapid Bagpipe')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Omicron'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Canine Geyser')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Pi'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Active Tinkerbell')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Rho'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Twilight Phantom')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Rho'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Clumsy Tiger')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Sigma'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Rapid Bagpipe')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Tau'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Purple Packer')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Upsilon'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Feline Behemoth')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Phi'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Frugal Bulldog')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Chi'),
    (SELECT contact_uuid FROM Contact WHERE contact_code_name = 'Hungry Rainbow')
);

INSERT INTO Mission_Hideout (
    mission_uuid,
    hideout_uuid
) VALUES (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Alpha'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Sunday’s Jupiter')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Beta'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Golden Harpie')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Epsilon'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Bleak Lancer')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Zeta'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Lonely lizard')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Zeta'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Feisty Supernova')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Eta'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Violet Packer')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Theta'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Flat Angler')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Iota'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Happy Beehive')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Kappa'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Quiet Cobra')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Lambda'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Needy Lyric')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Mu'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Impure Centurion')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Nu'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Warm Templer')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Omicron'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Candid Carbine')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Pi'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Icky Venus')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Rho'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Jolly Hunter')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Sigma'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Major Frostbite')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Tau'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Icky Venus')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Upsilon'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Feisty Supernova')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Phi'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Meaningful Street')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Chi'),
    (SELECT hideout_uuid FROM Hideout WHERE hideout_code_name = 'Needy Lyric')
);

INSERT INTO Mission_Target (
    mission_uuid,
    target_uuid
) VALUES (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Alpha'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Heavy Heart')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Beta'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Fire Phoenix')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Gamma'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Brief Star')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Delta'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Serious Toupee')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Epsilon'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Sad Ribbon')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Zeta'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Equal Behemoth')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Eta'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Faint Lizard')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Theta'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Blank Fox')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Iota'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Precious Spectator')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Kappa'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Fatal Thunder')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Lambda'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Basic Surgeon')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Mu'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Agile Dasher')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Nu'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Warm Falcon')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Xi'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Silver Dragonfly')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Omicron'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Amazing Mercury')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Pi'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Pink Eye')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Rho'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Early Gambit')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Sigma'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Silver Dragonfly')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Tau'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Bulky Grandpa')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Upsilon'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Equal Behemoth')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Phi'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Coarse Pebble')
), (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Chi'),
    (SELECT target_uuid FROM Target WHERE target_code_name = 'Basic Surgeon')
);

INSERT INTO Mission_Agent (
    mission_uuid,
    agent_uuid
) VALUES (
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Alpha'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '001')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Alpha'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '002')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Beta'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '003')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Gamma'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '004')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Delta'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '005')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Epsilon'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '006')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Zeta'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '007')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Eta'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '008')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Theta'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '009')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Iota'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '010')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Kappa'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '011')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Lambda'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '012')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Mu'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '013')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Nu'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '014')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Xi'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '015')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Omicron'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '016')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Pi'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '017')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Rho'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '018')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Sigma'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '019')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Tau'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '020')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Upsilon'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '021')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Phi'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '022')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Phi'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '023')
),(
    (SELECT mission_uuid FROM Mission WHERE mission_code_name = 'Mission Chi'),
    (SELECT agent_uuid FROM Agent WHERE agent_code = '024')
);
