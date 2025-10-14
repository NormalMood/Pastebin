DROP ROLE IF EXISTS pastebin_app;
CREATE ROLE pastebin_app WITH LOGIN PASSWORD 'vU1kAn_qZ2';



DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS sessions_tokens;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS names_taken;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS syntaxes;
DROP TABLE IF EXISTS intervals;
DROP TABLE IF EXISTS post_visibilities;



CREATE TABLE users(
	user_id SERIAL PRIMARY KEY,
	name VARCHAR(100) UNIQUE NOT NULL,
	e_mail VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(64) NOT NULL,
	picture_blob_link VARCHAR(180),
	created_at TIMESTAMPTZ NOT NULL,
	verification_token VARCHAR(64) UNIQUE,
	password_reset_token VARCHAR(64) UNIQUE,
	CHECK (CHAR_LENGTH(name) > 0),
	CHECK (CHAR_LENGTH(e_mail) > 0)
);
GRANT INSERT, SELECT, UPDATE, DELETE ON TABLE users TO pastebin_app;

CREATE TABLE sessions_tokens(
	session_token_id SERIAL PRIMARY KEY,
	session_token VARCHAR(64) NOT NULL UNIQUE,
	user_id INTEGER NOT NULL REFERENCES users(user_id),
	created_at TIMESTAMPTZ NOT NULL,
	expires_at TIMESTAMPTZ NOT NULL
);
GRANT INSERT, SELECT, UPDATE, DELETE ON TABLE sessions_tokens TO pastebin_app;

CREATE TABLE categories(
	category_id SMALLSERIAL PRIMARY KEY,
	name VARCHAR(80) UNIQUE NOT NULL
);
INSERT INTO categories(name)
    VALUES ('Без категории'),
           ('Деньги'),
           ('Домашние животные'),
           ('Духовность'),
           ('Еда'),
           ('Жильё'),
           ('Игры'),
           ('История'),
           ('Исходный код'),
           ('Кибербезопасность'),
           ('Криптовалюта'),
           ('Музыка'),
           ('Наука'),
           ('Письмо'),
           ('Помощь'),
           ('Программное обеспечение'),
           ('Путешествия'),
           ('Ремонт'),
           ('Спорт'),
           ('Телевидение'),
           ('Фильмы'),
           ('Фотография'),
           ('Хайку'),
           ('Шутки'),
           ('Юриспруденция');
GRANT SELECT ON TABLE categories TO pastebin_app;

CREATE TABLE syntaxes(
	syntax_id SMALLSERIAL PRIMARY KEY,
	name VARCHAR(35) UNIQUE NOT NULL,
	codemirror5_mode VARCHAR(35) UNIQUE NOT NULL
);
INSERT INTO syntaxes(name, codemirror5_mode)
    VALUES ('Текст', 'text/plain'),
		   ('Bash', 'shell'),
           ('C', 'text/x-csrc'),
           ('C#', 'text/x-csharp"'),
           ('C++', 'text/x-c++src'),
           ('CSS', 'css'),
           ('HTML', 'htmlmixed'),
           ('Java', 'text/x-java'),
           ('JavaScript', 'javascript'),
           ('PHP', 'php'),
           ('Python', 'python');
GRANT SELECT ON TABLE syntaxes TO pastebin_app;

CREATE TABLE intervals(
	interval_id SMALLSERIAL PRIMARY KEY,
	name VARCHAR(15) UNIQUE NOT NULL
);
INSERT INTO intervals(name)
	VALUES ('INFINITY'),
		   ('10 MINUTES'),
		   ('1 HOUR'),
		   ('1 DAY'),
		   ('1 WEEK'),
		   ('2 WEEKS'),
		   ('1 MONTH'),
		   ('6 MONTHS'),
		   ('1 YEAR');
GRANT SELECT ON TABLE intervals TO pastebin_app;

CREATE TABLE post_visibilities(
	post_visibility_id SMALLSERIAL PRIMARY KEY,
	name VARCHAR(15) UNIQUE NOT NULL
);
INSERT INTO post_visibilities(name)
	VALUES ('PUBLIC'),
		   ('UNLISTED');
GRANT SELECT ON TABLE post_visibilities TO pastebin_app;

CREATE TABLE posts(
	post_id SERIAL PRIMARY KEY,
	title VARCHAR(255),
	category_id SMALLINT NOT NULL REFERENCES categories(category_id),
	syntax_id SMALLINT NOT NULL REFERENCES syntaxes(syntax_id),
	interval_id SMALLINT NOT NULL REFERENCES intervals(interval_id),
	post_visibility_id SMALLINT NOT NULL REFERENCES post_visibilities(post_visibility_id),
	created_at TIMESTAMPTZ NOT NULL,
	expires_at TIMESTAMPTZ NOT NULL,
	post_link VARCHAR(8) UNIQUE NOT NULL,
	post_blob_link VARCHAR(90) NOT NULL,
	user_id INTEGER REFERENCES users(user_id),
	CHECK (CHAR_LENGTH(post_link) = 8)
);
GRANT INSERT, SELECT, UPDATE, DELETE ON TABLE posts TO pastebin_app;

CREATE TABLE names_taken(
	name_taken_id SERIAL PRIMARY KEY,
	name VARCHAR(100) UNIQUE NOT NULL,
	CHECK (CHAR_LENGTH(name) > 0)
);
GRANT INSERT, SELECT ON TABLE names_taken TO pastebin_app;


GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public TO pastebin_app;