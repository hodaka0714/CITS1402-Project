drop table if exists Products;
create table Products(
id int not null auto_increment primary key,
Code int unsigned,
Name varchar(30),
Price int unsigned,
Quantity int,
Description text
);

drop table if exists Orders;
create table Orders(
id int not null auto_increment primary key,
Firstname varchar(30),
Lastname varchar(30),
Phone varchar(10),
Address varchar(255),
ProductID int,
Quantity int,
Price int
);

insert into Products (Code, Name, Price, Quantity, Description) values (1001,'Hygrogen',1008,3,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1002,'Helium',4002,14,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1003,'Lithium',6940,159,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1004,'Beryllium',90122,2,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1005,'Boron',1081,65,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1006,'Carbon',1201,35,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1007,'Nitrogen',1400,8,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1008,'Oxygen',15999,97,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1009,'Fluorine',18998,9,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1010,'Neon',20180,32,'This chemical element is very useful in our life');
insert into Products (Code, Name, Price, Quantity, Description) values (1011,'Sodium',22990,38,'This chemical element is very useful in our life');

insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Noah','Smith','0123456789','2 Park Road',3,2,582);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Liam','Jones','1234567890','3 Park Road',1,3,84);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('William','Williams','2345678901','4 Park Road',4,7,9837);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Olivia','White','7890123456','12 Park Road',3,24,954);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Mason','Brown','3456789012','5 Park Road',1,5,81944);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('James','Wilson','4567890234','7 Park Road',5,2,928);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Benjamin','Taylor','5678902345','8 Park Road',9,8,93);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Emma','Johnson','6789012345','9 Park Road',2,11,1998);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Olivia','White','7890123456','12 Park Road',6,23,9);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Ava','Martin','8901234567','22 Park Road',5,2,78);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Olivia','White','7890123456','12 Park Road',6,24,94);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Sophia','Anderson','9012345678','62 Park Road',3,91,103);
insert into Orders (Firstname, Lastname, Phone, Address, ProductID, Quantity,  Price) values ('Isabella','Thompson','1123456789','42 Park Road',5,3,894);


/* 
Query 1: What SQL query will produce the row of customer information who have
made three or more successful orders from this shop? */

select Firstname, Lastname, Phone, Address, count(*) from Orders 
group by Firstname having count(*) >= 3;


/* 
Query 2: What SQL query will produce the row of customer information who have
spent $500 or more in total in this shop?*/

select * from Orders 
group by Firstname having Price >= 500;


/* 
Query 3: What SQL query will list the product information where no customers
bought this product before?*/

select P.id, P.Code, P.Name, P.Price, P.Quantity, P.Description from Products P 
where P.id not in (select ProductID from Orders);


/* 
Query 4: What SQL query will list the product information where only one
customer bought this product before?*/

select P.id, P.Code, P.Name, P.Price, P.Quantity, P.Description, count(*) from Products P 
inner join Orders O where P.id = O.ProductID 
group by ProductID having count(*) = 1;


/* 
Query 5: What SQL query will list the total number of customer orders per product
in the database?*/

select P.id, P.Name, count(*) as numOfCustomerPerProduct from Products P 
inner join Orders O where P.id = O.ProductID group by ProductID;


/* 
Query 6: What SQL Query will produce the total amount of the sold products in the
database?*/
select sum(Quantity) as TotalAmountOfSoldProducts from Orders;


/* 
Query 7: Write a function CostOfBestBuyers(number INT) Return Double that
returns the total price of the top number of customers who spent in this shop. For
instance, if number =5, the returned price is the total cost of the 5 customers who
spent the most in this shop.  */

drop procedure if exists CostOfBestBuyer;
create procedure CostOfBestBuyer(IN number INT, OUT money INT)
select sum(Price) from Orders order by Price desc limit number into money;

	/*
	call CostOfBestBuyer( 5 , @money ); 
	select @money;
	*/


/* 
Query 8: Create a view BuyerCostPerProduct with columns Customer ID, Customer
Name, Product ID, Product Name, Date which provides a more accessible way for
the DB user to run queries regarding customers and products. The date is the time
to produce the view. In other words, the virtual table view maintains each buyer’s
cost for each product by a view generation date.  */

drop view if exists BuyerCostPerProduct;
create view BuyerCostPerProduct as 
select 
	O.id as ustomerID, 
	O.Firstname as CustomerFirstName, 
	O.Lastname as CustomerLastName,
	P.id as ProductID, 
	P.Name as ProductName, 
	now() as Date 
from Products P, Orders O
where P.id = O.ProductID;

select * from BuyerCostPerProduct;



