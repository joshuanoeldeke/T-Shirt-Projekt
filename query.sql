drop database silkskull;

create database silkskull;

use silkskull;

create table products (
    id int primary key auto_increment,
    title varchar(255),
    price decimal,
    category varchar(255),
    description varchar(255),
    image varchar(255)
);

create table adress (
                        adress_id int primary key auto_increment,
                        email varchar(255),
                        firstname varchar(255),
                        lastname varchar(255),
                        street varchar(255),
                        city varchar(255),
                        postalcode varchar(255)
);

create table order_table (
    order_id int primary key auto_increment,
    adress_id int,
    date datetime,
    foreign key (adress_id) references adress(adress_id)
);

create table order_products (
    order_id int,
    product_id int,
    amount decimal,
    foreign key (order_id) references order_table(order_id),
    foreign key (product_id) references products(id),
    primary key (order_id,product_id)
);


create table cart (
    cart_id int primary key auto_increment,
    product varchar(255),
    name varchar(255),
    price decimal,
    quantity int,
    id int,
    timestamp datetime
);

create table user (
    username varchar(255) primary key,
    password varchar(255)
);


INSERT INTO products (title, price, category, description, image)
VALUES ('T-Shirt', 8.56, 'clothing', 'Dies ist eine Beschreibung für Produkt 1', 'https://media.discordapp.net/attachments/1197137018145214555/1199683672190754816/tshirt_schwarz.jpg?ex=65c36f7c&is=65b0fa7c&hm=e135b142ec16bee04c7514d9cc8cd74685be1374b19452288177198fb0fd024e&=&format=webp&width=1029&height=1201');

INSERT INTO products (title, price, category, description, image)
VALUES ('T-Shirt', 39.99, 'clothing', 'Dies ist eine Beschreibung für Produkt 2', 'https://media.discordapp.net/attachments/1197137018145214555/1199683671075074158/Hoodie_schwarz.jpg?ex=65c36f7c&is=65b0fa7c&hm=2d720854217051f51654fc2adb3c050a6dd57a83cbf868e9732d827a3a7636f1&=&format=webp&width=1029&height=1201');

INSERT INTO products (title, price, category, description, image)
VALUES ('Porsche SMan Cay', 299999.99, 'vehicles', 'Dies ist eine Beschreibung für Produkt 3', 'https://media.discordapp.net/attachments/1197137018145214555/1199689111544528986/porsche.jpg?ex=65c3748d&is=65b0ff8d&hm=2af32224ad17a761bb43d6f180a490444e18f647da11b69c8337564b4c585ba6&=&format=webp&width=1029&height=1201');

INSERT INTO products (title, price, category, description, image)
VALUES ('USB-Stick', 9.99, 'tech', 'Dies ist eine Beschreibung für Produkt 4', 'https://media.discordapp.net/attachments/1197137018145214555/1199686825321701406/usb-flash-drive.png?ex=65c3726c&is=65b0fd6c&hm=5ea1535dae965f973ecd4108ee870eb381cef2800f47e8d4732a002d94717789&=&format=webp&quality=lossless&width=1030&height=1201');


insert into user (username, password) VALUES ('admin', 'password');
insert into user (username, password) VALUES ('mitarbeiter1', 'password1');


CREATE VIEW OrderOverview AS
SELECT
    o.order_id,
    p.title AS product_name,
    op.amount AS quantity,
    p.price,
    op.amount * p.price AS total_price,
    a.email,
    a.firstname,
    a.lastname,
    a.street,
    a.city,
    a.postalcode
FROM
    order_table o
        JOIN
    adress a ON o.adress_id = a.adress_id
        JOIN
    order_products op ON o.order_id = op.order_id
        JOIN
    products p ON op.product_id = p.id
ORDER BY o.order_id ASC;
