# CITS1402-Project

This repository is for recording of my assignment.
2017/10/12

-----------------------------------------------

CITS1402 RDBMS Project Description in 2017 Semester 2

Nowadays, most commercial shops have their own web sites for sale and databases for managing their sales. They use relational database system to manage their new arrivals, the products kept in stock, the customers' transactions or orders and their customers' information. These maintained information will help shop managers to track their sales in their shops. In addition, they often provide online sales that allow customers make their orders via shop web sites. The online web sites are often developed and connected to their database systems. The online web sites can also help shop managers to manage their databases for those who don't have specific IT knowledge. To develop this application, you need to have the basic skills and knowledge about relational database concepts, MySQL queries, HTML, PHP. 
All these have been delivered in this unit of CITS1402 - relational database management system, 2017 Semester 2. Therefore, this project based assignment includes three components as below:


Part 1: Database Design [3 Marks]

You are required to design a database including all the mandatory tables. 
Your designed database should meet the requirements described in the practical application. Regarding Part 1, you MUST create all the tables in your database on the web server cits1402.csse.uwa.edu.au. For each table, you MUST insert at least 10 rows as test data. Meanwhile, you MUST submit a ***.sql file named as your-own-studentID.sql (e.g., 123456.sql). In the .sql file, you have to include all your mysql queries used for creating tables, inserting rows.


Part 2: SQL Queries [7 Marks, 0.5 mark for each query in Query1-6, 2 mark for Query7-8]

Query 1: What SQL query will produce the row of customer information who have made three or more successful orders from this shop?

Query 2: What SQL query will produce the row of customer information who have spent $500 or more in total in this shop?

Query 3: What SQL query will list the product information where no customers bought this product before?

Query 4: What SQL query will list the product information where only one customer bought this product before?

Query 5: What SQL query will list the total number of customer orders per product in the database?

Query 6: What SQL Query will produce the total amount of the sold products in the database?

Query 7: Write a function CostOfBestBuyers(number INT) Return Double that returns the total price of the top number of customers who spent in this shop. For instance, if number =5, the returned price is the total cost of the 5 customers who spent the most in this shop.

Query 8: Create a view BuyerCostPerProduct with columns Customer ID, Customer Name, Product ID, Product Name, Cost, Date which provides a more accessible way for the DB user to run queries regarding customers and products. The date is the time to produce the view. The cost is the total expenditure of a customer regarding a product. In other words, the virtual table view maintains each buyer’s cost for each product by a view generation date.

The above 8 MySQL queries MUST be included in the submitted file your-own-studentID.sql (e.g., 123456.sql).


Part 3: Database Driven Web Site Development [10 Marks]

Task 3.1: New Arriving Product Submission Web Page [2 Marks]
In this page, you need to develop a web page NewArriving.php including HTML form part and PHP part. Shop manager can submit the new arriving product item information and write it into the Database. The written item information must include product code, product name, product price, and quantity. After the item information is written into database successfully, it should display a confirmation message on the web page and let the shop manager to know the successful insertion.

Task 3.2: User Buying Product Transaction Web Page [6 Marks]
In this page, you need to develop a web page BuyingTransaction.php including HTML form and PHP part. A user can make her/his order through the HTML form. It is required to provide a drop down list allowing the user to choose one product. It also needs an input field allowing the user to specify the quantity of product she or he wants to buy. It also asks user to provide her/his personal information including user name, phone number, and address.
PHP part will be used to calculate the total price and print a message for the user. If the number of her/his ordered product doesn't exceed the available quantity of the product in database, then you need print a message on the web page including a successful confirmation about the user's order and the total price of this order. You also need to update the available quantity of the product in the database. If the transaction is successful, you also need to record the user information, transaction information in the database. If the number of her/his ordered product exceeds the available quantity of the product in database, then it says the transaction failed. So you need to show a message on the web page. It tells the user the failed transaction and the available quantity of the product.

Task 3.3: User-friendly Web Page Design [2 Marks]
All the web pages should be designed in a well format. It should be reasonable, attractive, user-friendly, and informative.
Regarding Part 3, you MUST submit TWO web pages, each for Task 3.1 and each for Task 3.2. The first web page is named as NewArriving.php. The second web page is named as BuyingTransaction.php.

Submission Requirements and Format:
This is an individual assignment. You have to develop by your own and cannot copy the codes from the others. You have to submit 4 files including your-own-studentID.sql, NewArriving.php, and BuyingTransaction.php, declaration.txt via the link in Blackboard by the Assignment Due Date.

Meanwhile, you have to test NewArriving.php and BuyingTransaction.php on your web server, and also upload the two web pages to your web folder \\cits1402.csse.uwa.edu.au\www by the Assignment Due Date.

In declaration.txt, you MUST include
? your web site address http://cits1402.csse.uwa.edu.au/~Your-Student-ID/
? Your web DB password.
? Completed tasks and non-completed tasks.

Any change after the due date is not allowed.

Submission Due Date:

Thursday 24:00 in Week 11, October 19th, 2017
