CREATE TABLE categories(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL
);


CREATE TABLE authors(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,

    name VARCHAR(255) NOT NULL,
    bio  VARCHAR(255) NOT NULL
);

CREATE TABLE books(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,

    title        VARCHAR(255) NOT NULL,
    description  VARCHAR(255) NOT NULL,
    year         DATE NOT NULL,
    
    author_id    INTEGER NOT NULL,
    category_id  INTEGER NOT NULL


    -- CONSTRAINT author_id_constraint FOREIGN KEY (author_id) REFERENCES author(id),
    -- CONSTRAINT category_id_constraint FOREIGN KEY (category_id) REFERENCES category(id),
);


INSERT INTO books(
    title,
    description,
    year,
    author_id,
    category_id
) VALUES (
    'Adicionando um livro de teste',
    'Esse é um livro de teste',
    '2023-06-03',
    1,
    2
);

