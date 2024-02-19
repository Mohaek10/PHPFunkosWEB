
DROP TABLE IF EXISTS "categorias";
CREATE TABLE "public"."categorias" (
    "id" uuid NOT NULL,
    "nombre" character varying(255) NOT NULL,
    "created_at" timestamp DEFAULT now() NOT NULL,
    "updated_at" timestamp DEFAULT now() NOT NULL,
    "is_deleted" boolean DEFAULT false NOT NULL,
    CONSTRAINT "PK_3886a26251605c571c6b4f861fe" PRIMARY KEY ("id"),
    CONSTRAINT "UQ_ccdf6cd1a34ea90a7233325063d" UNIQUE ("nombre")
) WITH (oids = false);

INSERT INTO "categorias" ("id", "nombre", "created_at", "updated_at", "is_deleted") VALUES
('939cf843-5ecd-477c-a68a-0207122a4a88',	'Marvel',	'2024-01-08 15:01:33.423473',	'2024-01-08 15:01:33.423473',	'f'),
('9ec926bd-36ab-43c4-aeaa-11c4f18b9cc8',	'DC',	'2024-01-08 15:01:33.423473',	'2024-01-08 15:01:33.423473',	'f'),
('5f93881a-e486-4aa7-ad6d-b9f23a967695',	'Anime',	'2024-01-08 15:01:33.423473',	'2024-01-08 15:01:33.423473',	'f'),
('cf81a106-447d-4933-830f-0eb1ac929ad2',	'Videojuegos',	'2024-01-08 15:01:33.423473',	'2024-01-08 15:01:33.423473',	'f');

DROP TABLE IF EXISTS "funko";
DROP SEQUENCE IF EXISTS funko_id_seq;
CREATE SEQUENCE funko_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."funko" (
    "id" bigint DEFAULT nextval('funko_id_seq') NOT NULL,
    "nombre" character varying(255) NOT NULL,
    "precio" character varying(255) NOT NULL,
    "cantidad" integer DEFAULT '0' NOT NULL,
    "imagen" character varying DEFAULT 'https://via.placeholder.com/150' NOT NULL,
    "createdat" timestamp DEFAULT now() NOT NULL,
    "updatedat" timestamp DEFAULT now() NOT NULL,
    "is_deleted" boolean DEFAULT false NOT NULL,
    "categoria_id" uuid,
    CONSTRAINT "PK_2159f453346bb15653b8825f3ec" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "funko" ("id", "nombre", "precio", "cantidad", "imagen", "createdat", "updatedat", "is_deleted", "categoria_id") VALUES
(4,	'Messi',	'100000000',	2,	'http://localhost:8080/uploads/65d33f42a6905.jpg',	'2024-02-19 11:44:11',	'2024-02-19 11:45:06',	'f',	'cf81a106-447d-4933-830f-0eb1ac929ad2'),
(2,	'IronMan',	'300000',	20,	'http://localhost:8080/uploads/65d33f845eb15.jpg',	'2024-01-08 19:32:40.05201',	'2024-02-19 11:46:12',	'f',	'939cf843-5ecd-477c-a68a-0207122a4a88'),
(1,	'Spiderman',	'500000',	20,	'http://localhost:8080/uploads/65d33fbbefbeb.jpg',	'2024-01-08 15:01:41.953773',	'2024-02-19 11:47:07',	'f',	'939cf843-5ecd-477c-a68a-0207122a4a88'),
(3,	'Batman',	'9090099',	20,	'http://localhost:8080/uploads/65d34023a01ab.jpg',	'2024-01-09 19:32:40.05201',	'2024-02-19 11:48:51',	'f',	'939cf843-5ecd-477c-a68a-0207122a4a88');

DROP TABLE IF EXISTS "user_roles";
CREATE TABLE "public"."user_roles" (
    "user_id" bigint NOT NULL,
    "roles" character varying(255)
) WITH (oids = false);

INSERT INTO "user_roles" ("user_id", "roles") VALUES
(1,	'USER'),
(1,	'ADMIN'),
(2,	'USER'),
(2,	'USER'),
(3,	'USER'),
(5,	'USER'),
(6,	'USER'),
(5,	'ADMIN');

DROP TABLE IF EXISTS "usuarios";
DROP SEQUENCE IF EXISTS usuarios_id_seq;
CREATE SEQUENCE usuarios_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."usuarios" (
    "is_deleted" boolean DEFAULT false,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "id" bigint DEFAULT nextval('usuarios_id_seq') NOT NULL,
    "updated_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "apellidos" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "nombre" character varying(255) NOT NULL,
    "password" character varying(255) NOT NULL,
    "username" character varying(255) NOT NULL,
    CONSTRAINT "usuarios_email_key" UNIQUE ("email"),
    CONSTRAINT "usuarios_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "usuarios_username_key" UNIQUE ("username")
) WITH (oids = false);

INSERT INTO "usuarios" ("is_deleted", "created_at", "id", "updated_at", "apellidos", "email", "nombre", "password", "username") VALUES
('f',	'2023-11-02 11:43:24.724871',	1,	'2023-11-02 11:43:24.724871',	'Admin Admin',	'admin@prueba.net',	'Admin',	'$2a$10$vPaqZvZkz6jhb7U7k/V/v.5vprfNdOnh4sxi/qpPRkYTzPmFlI9p2',	'admin'),
('f',	'2023-11-02 11:43:24.730431',	2,	'2023-11-02 11:43:24.730431',	'User User',	'user@prueba.net',	'User',	'$2a$12$RUq2ScW1Kiizu5K4gKoK4OTz80.DWaruhdyfi2lZCB.KeuXTBh0S.',	'user'),
('f',	'2023-11-02 11:43:24.733552',	3,	'2023-11-02 11:43:24.733552',	'Test Test',	'test@prueba.net',	'Test',	'$2a$10$Pd1yyq2NowcsDf4Cpf/ZXObYFkcycswqHAqBndE1wWJvYwRxlb.Pu',	'test'),
('f',	'2023-11-02 11:43:24.736674',	4,	'2023-11-02 11:43:24.736674',	'Otro Otro',	'otro@prueba.net',	'otro',	'$2a$12$3Q4.UZbvBMBEvIwwjGEjae/zrIr6S50NusUlBcCNmBd2382eyU0bS',	'otro'),
('f',	'2024-02-19 11:36:35.793621',	5,	'2024-02-19 11:36:35.793621',	'El Kasmi',	'elkasmimoha@gmail.com',	'Moha',	'$2y$10$vWLzwt90OPUGCL9l.pvyBObi6HtfibfGrCu08JsD46VNqWkBTasr6',	'mohaek'),
('f',	'2024-02-19 11:41:26.212735',	6,	'2024-02-19 11:41:26.212735',	'El Chocolatero',	'ekmoha0@gmail.com',	'Paco',	'$2y$10$a/vEJlE1hXko9cMCf8OTB.p0p/rRe.u2n3jj3/8voO.XYj6Z2NkhG',	'paquito');

ALTER TABLE ONLY "public"."user_roles" ADD CONSTRAINT "fk2chxp26bnpqjibydrikgq4t9e" FOREIGN KEY (user_id) REFERENCES usuarios(id) NOT DEFERRABLE;

