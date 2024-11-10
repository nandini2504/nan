Q1
CREATE TABLE Emp (
    emp_id number primary key,
    emp_name varchar2(100),
    salary number,
    designation varchar(50)
);
CREATE TABLE tracking(
    emp_id number,
    old_salary number,
    new_salary number,
    salary_diff number,
    CONSTRAINTS fk_emp FOREIGN KEY(emp_id) REFERENCES Emp(emp_id)   
);
INSERT INTO Emp(emp_id,emp_name,salary,designation) VALUES(101,'rudra',75000,'manager');
INSERT INTO Emp(emp_id,emp_name,salary,designation) VALUES(102,'ali',95000,'CEO');
INSERT INTO Emp(emp_id,emp_name,salary,designation) VALUES(103,'Anuja',85000,'Hacker');
INSERT INTO Emp(emp_id,emp_name,salary,designation) VALUES(104,'Yumiko',65000,'Developer');

CREATE OR REPLACE TRIGGER trg
AFTER UPDATE OF salary on Emp
FOR EACH ROW
WHEN (OLD.salary!=NEW.salary) 
BEGIN
 INSERT INTO tracking(emp_id,old_salary,new_salary,salary_diff)
 VALUES (:OLD.emp_id,:OLD.salary,:NEW.salary,:NEW.salary-:OLD.salary);
END;
/
CREATE OR REPLACE TRIGGER trg_del
BEFORE DELETE on Emp
FOR EACH ROW
BEGIN
IF :OLD.designation='CEO' THEN
RAISE_APPLICATION_ERROR(-20001,'you cannot delete an employee with designation CEO');
END IF;
END;
/
update Emp;
set salary=85000
where emp_id =101
delete from Emp
where emp_id=102;
select*from tracking;
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.2

package TEJAS;

import java.util.Scanner;

import com.mongodb.BasicDBObject;
import com.mongodb.DB;
import com.mongodb.DBCollection;
import com.mongodb.DBCursor;
import com.mongodb.MongoClient;

public class CONNECTION {
private static Scanner sc2;
public static void main( String args[] )
{
	DBCollection coll=null;
	try{
		// To connect to mongodb server
		MongoClient mongoClient = new MongoClient( "localhost" , 27017 );
		// Now connect to your database
		DB db = mongoClient.getDB("demo");
		// Selecting the Collection
		coll = db.getCollection("friend");
		System.out.println("Connected to database successfully");
		sc2 = new Scanner(System.in);
		int choice;
		do {
			System.out.println("Enter your choice of operation \n1. Display All \n2. Insert Document \n3. Delete Document \n4. Update \n5. Conditional Display \n6.Exit \n");
			choice = sc2.nextInt();
			switch (choice) {
			case 1:displayAll(coll);
			break;
			case 2: insertDoc(coll);
			break;
			case 3: deleteDoc(coll);
			break;
			case 4: updateDoc(coll);
			break;
			case 5: conditionalDisplay(coll);
			break;
			case 6: System.out.println("Exiting Program...");
			System.exit(0);
			break;
			default:
				System.out.println(choice + " is not a valid Menu Option! Please Select Another.");
			}
		}
		while(choice != 6);
		}
	catch(Exception ex){
			ex.printStackTrace();
		}
	}
	public static void insertDoc(DBCollection coll)
	{
		System.out.println("Inserting document");
		BasicDBObject document = new BasicDBObject();
		System.out.println("Enter Student rollno");
		Scanner sc=new Scanner(System.in);
		int sroll = sc.nextInt();
		System.out.println("Enter Student Name");
		String sname = sc.next();
		System.out.println("Enter Student Class");
		String sclass = sc.next();
		System.out.println("Enter Student Marks");
		int smarks = sc.nextInt();
		System.out.println("Enter Student Technical Interest");
		String sti = sc.next();
		document.put("stu_rollno",sroll);
		document.put("stu_name",sname);
		document.put("class",sclass);
		document.put("marks",smarks);
		document.put("technical_interest",sti);
		coll.insert(document);
		System.out.println("Document inserted successfully");
	}
	public static void deleteDoc(DBCollection coll)
	{
		System.out.println("Deleting document");
		BasicDBObject document = new BasicDBObject();
		System.out.println("Enter Student rollno");
		Scanner sc=new Scanner(System.in);
		int sroll = sc.nextInt();
		document.put("stu_rollno",sroll);
		coll.remove(document);
		System.out.println("Document deleted successfully");
	}
	public static void updateDoc(DBCollection coll)
	{
		System.out.println("Updating document");
		System.out.println("Enter Student rollno");
		Scanner sc1=new Scanner(System.in);
		int sroll = sc1.nextInt();
		BasicDBObject searchQuery = new	BasicDBObject().append("stu_rollno", sroll);
		BasicDBObject newDocument = new BasicDBObject();
		System.out.println("Enter New marks");
		Scanner sc=new Scanner(System.in);
		int smarks = sc.nextInt();
		newDocument.append("$set", new BasicDBObject().append("marks",smarks));
		coll.update(searchQuery,newDocument);
		System.out.println("Document updated successfully");
	}
	public static void displayAll(DBCollection coll)
	{
		System.out.println("Displaying all documents in collection");
		DBCursor cursor = coll.find();
		while(cursor.hasNext()) 
		{
			System.out.println(cursor.next());
		}
	}
	public static void conditionalDisplay(DBCollection coll)
	{
		System.out.println("Enter Minimum marks");
		Scanner sc=new Scanner(System.in);
		int smarks=sc.nextInt();
		DBCursor cursor = coll.find();
		while(cursor.hasNext()) 
		{
		int marks=(int) cursor.next().get("marks");
		if(marks > smarks )
		{
			System.out.println(cursor.curr());
		}
		else
			System.out.println("Minimum marks");
		}
		}
	}
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q3
use your_database_name; // Switch to your database

// Create the collection
db.createCollection("Movies_Data");

// Sample data to insert
const movies = [
    { Movie_ID: 1, Movie_Name: "Inception", Director: "Christopher ", Genre: "Sci-Fi", BoxOfficeCollection: 829895144 },
    { Movie_ID: 2, Movie_Name: "The Dark Knight", Director: "Christopher ", Genre: "Action", BoxOfficeCollection: 1004558444 },
    { Movie_ID: 3, Movie_Name: "Interstellar", Director: "Christopher ", Genre: "Sci-Fi", BoxOfficeCollection: 677716387 },
    { Movie_ID: 4, Movie_Name: "Parasite", Director: "Bong Joon-ho", Genre: "Thriller", BoxOfficeCollection: 263201553 },
    { Movie_ID: 5, Movie_Name: "Avatar", Director: "James Cameron", Genre: "Fantasy", BoxOfficeCollection: 2847246203 },
    { Movie_ID: 6, Movie_Name: "Titanic", Director: "James Cameron", Genre: "Romance", BoxOfficeCollection: 2187463944 },
    { Movie_ID: 7, Movie_Name: "Get Out", Director: "Jordan Peele", Genre: "Horror", BoxOfficeCollection: 255439561 },
    { Movie_ID: 8, Movie_Name: "The Matrix", Director: "Lana ", Genre: "Sci-Fi", BoxOfficeCollection: 463517383 },
    { Movie_ID: 9, Movie_Name: "The Godfather", Director: "Francis Ford ", Genre: "Crime", BoxOfficeCollection: 246120974 },
];
db.Movies_Data.insertMany(movies);
db.Movies_Data.aggregate([
    {
        $group: {
            _id: "$Director",
            count: { $sum: 1 }
        }
    },
    {
        $project: {
            Director: "$_id",
            MovieCount: "$count",
            _id: 0
        }
    }
]);
db.Movies_Data.aggregate([
    {
        $group: {
            _id: { Genre: "$Genre" },
            HighestBoxOffice: { $max: "$BoxOfficeCollection" }
        }
    },
    {
        $lookup: {
            from: "Movies_Data",
            localField: "HighestBoxOffice",
            foreignField: "BoxOfficeCollection",
            as: "movies"
        }
    },
    {
        $unwind: "$movies"
    },
    {
        $project: {
            Genre: "$_id.Genre",
            Movie: "$movies.Movie_Name",
            Director: "$movies.Director",
            HighestBoxOffice: "$HighestBoxOffice",
            _id: 0
        }
    }
]);
db.Movies_Data.aggregate([
    {
        $group: {
            _id: { Genre: "$Genre" },
            HighestBoxOffice: { $max: "$BoxOfficeCollection" }
        }
    },
    {
        $lookup: {
            from: "Movies_Data",
            localField: "HighestBoxOffice",
            foreignField: "BoxOfficeCollection",
            as: "movies"
        }
    },
    {
        $unwind: "$movies"
    },
    {
        $project: {
            Genre: "$_id.Genre",
            Movie: "$movies.Movie_Name",
            Director: "$movies.Director",
            HighestBoxOffice: "$HighestBoxOffice",
            _id: 0
        }
    },
    {
        $sort: { HighestBoxOffice: 1 }
    }
]);
db.Movies_Data.createIndex({ Movie_ID: 1 });
db.Movies_Data.createIndex({ Movie_Name: 1, Director: 1 });
db.Movies_Data.dropIndex("Movie_ID_1");
db.Movies_Data.dropIndex("Movie_Name_1_Director_1");

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q4 
-- Step 1: Create Account table
CREATE TABLE Account (
    Account_No NUMBER PRIMARY KEY,        -- Account number is primary key
    Cust_Name VARCHAR2(100),              -- Customer name
    Balance NUMBER,                       -- Account balance
    NoOfYears NUMBER                      -- Number of years the account has been active
);

-- Step 2: Create Earned_Interest table
CREATE TABLE Earned_Interest (
    Account_No NUMBER REFERENCES Account(Account_No),  -- Foreign key from Account table
    Interest_Amt NUMBER                                -- Calculated interest amount
);

-- Step 3: Insert sample data into Account table
INSERT INTO Account (Account_No, Cust_Name, Balance, NoOfYears) 
VALUES (123456, 'rudra', 60000, 5);

INSERT INTO Account (Account_No, Cust_Name, Balance, NoOfYears) 
VALUES (234567, 'anuja', 45000, 3);

INSERT INTO Account (Account_No, Cust_Name, Balance, NoOfYears) 
VALUES (345678, 'tejas', 80000, 4);

INSERT INTO Account (Account_No, Cust_Name, Balance, NoOfYears) 
VALUES (456789, 'anushka', 52000, 2);

INSERT INTO Account (Account_No, Cust_Name, Balance, NoOfYears) 
VALUES (567890, 'bhavesh', 47000, 3);

COMMIT;

-- Step 4: Create Procedure to calculate interest and store in Earned_Interest table
CREATE OR REPLACE PROCEDURE Calculate_Interest (
    p_Account_No IN Account.Account_No%TYPE,      -- Account number input
    p_Interest_Rate IN NUMBER                     -- Interest rate input
) 
IS
    v_Balance Account.Balance%TYPE;               -- Variable to store balance
    v_NoOfYears Account.NoOfYears%TYPE;           -- Variable to store number of years
    v_Interest_Amt NUMBER;                        -- Variable to store calculated interest
BEGIN
    -- Fetch the balance and number of years for the given Account_No
    SELECT Balance, NoOfYears
    INTO v_Balance, v_NoOfYears
    FROM Account
    WHERE Account_No = p_Account_No;

    -- Calculate Simple Interest
    v_Interest_Amt := (v_Balance * p_Interest_Rate * v_NoOfYears) / 100;

    -- Insert the interest amount into the Earned_Interest table
    INSERT INTO Earned_Interest (Account_No, Interest_Amt)
    VALUES (p_Account_No, v_Interest_Amt);

    COMMIT;

    -- Display all records from Earned_Interest table
    FOR rec IN (SELECT * FROM Earned_Interest) LOOP
        DBMS_OUTPUT.PUT_LINE('Account_No: ' || rec.Account_No || ', Interest_Amt: ' || rec.Interest_Amt);
    END LOOP;
END;
/

-- Step 5: Create Function to display accounts with Balance greater than 50,000
CREATE OR REPLACE FUNCTION Get_Accounts_With_High_Balance
RETURN SYS_REFCURSOR
IS
    cur_accounts SYS_REFCURSOR;   -- Define cursor to hold result set
BEGIN
    -- Open the cursor for fetching all records from Account table where Balance > 50000
    OPEN cur_accounts FOR
    SELECT * FROM Account
    WHERE Balance > 50000;
    
    -- Return the cursor
    RETURN cur_accounts;
END;
/

-- Step 6: Example to call the procedure Calculate_Interest
BEGIN
    Calculate_Interest(123456, 5);  -- Example: Account_No = 123456, Interest Rate = 5%
END;
/

-- Step 7: Example to call the function Get_Accounts_With_High_Balance and display results
DECLARE
    v_accounts SYS_REFCURSOR;         -- Cursor to store function result
    v_Account_No Account.Account_No%TYPE;   -- Variable to store Account_No
    v_Cust_Name Account.Cust_Name%TYPE;     -- Variable to store Cust_Name
    v_Balance Account.Balance%TYPE;         -- Variable to store Balance
    v_NoOfYears Account.NoOfYears%TYPE;     -- Variable to store NoOfYears
BEGIN
    v_accounts := Get_Accounts_With_High_Balance;  -- Get accounts with balance > 50000

    -- Fetch and display each row
    LOOP
        FETCH v_accounts INTO v_Account_No, v_Cust_Name, v_Balance, v_NoOfYears;
        EXIT WHEN v_accounts%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('Account_No: ' || v_Account_No || ', Cust_Name: ' || v_Cust_Name || ', Balance: ' || v_Balance || ', NoOfYears: ' || v_NoOfYears);
    END LOOP;

    -- Close the cursor
    CLOSE v_accounts;
END;
/
---------------------------------------------------------------------------------
Q5
-- Create Locations table
CREATE TABLE Locations (
    Location_id NUMBER PRIMARY KEY,
    Street_address VARCHAR2(255),
    Postal_code VARCHAR2(20),
    City VARCHAR2(100),
    State VARCHAR2(100),
    Country_id VARCHAR2(2)
);

-- Create Departments table
CREATE TABLE Departments (
    Department_id NUMBER PRIMARY KEY,
    Department_name VARCHAR2(100),
    Manager_id NUMBER,
    Location_id NUMBER,
    CONSTRAINT fk_location FOREIGN KEY (Location_id) REFERENCES Locations(Location_id)
);

-- Create Manager table
CREATE TABLE Manager (
    Manager_id NUMBER PRIMARY KEY,
    Manager_name VARCHAR2(100)
);

-- Create Employee table
CREATE TABLE Employee (
    Employee_id NUMBER PRIMARY KEY,
    First_name VARCHAR2(100),
    Last_name VARCHAR2(100),
    Hire_date DATE,
    Salary NUMBER,
    Job_title VARCHAR2(100),
    Manager_id NUMBER,
    Department_id NUMBER,
    CONSTRAINT fk_manager FOREIGN KEY (Manager_id) REFERENCES Manager(Manager_id),
    CONSTRAINT fk_department FOREIGN KEY (Department_id) REFERENCES Departments(Department_id)
);

-- Insert sample data into Locations table
INSERT INTO Locations VALUES (1, 'vikas chowk', '12345', 'sangli', 'SN', 'India');
INSERT INTO Locations VALUES (2, 'gb road', '67890', 'Dhule', 'DH', 'India');

-- Insert sample data into Departments table
INSERT INTO Departments VALUES (1, 'IT', 1, 1);
INSERT INTO Departments VALUES (2, 'HR', 2, 2);
INSERT INTO Departments VALUES (3, 'Finance', 3, 1);

-- Insert sample data into Manager table
INSERT INTO Manager VALUES (1, 'tejas');
INSERT INTO Manager VALUES (2, 'bhavesh');
INSERT INTO Manager VALUES (3, 'rudra');

-- Insert sample data into Employee table
INSERT INTO Employee VALUES (101, 'tejas', 'Williams', TO_DATE('2008-06-10', 'YYYY-MM-DD'), 90000, 'Developer', 1, 1);
INSERT INTO Employee VALUES (102, 'bhavesh', 'Adams', TO_DATE('2005-08-12', 'YYYY-MM-DD'), 50000, 'HR Specialist', 2, 2);
INSERT INTO Employee VALUES (103, 'rudra', 'Brown', TO_DATE('2010-11-05', 'YYYY-MM-DD'), 120000, 'CFO', 3, 3);
INSERT INTO Employee VALUES (104, 'Dana', 'White', TO_DATE('2004-07-15', 'YYYY-MM-DD'), 75000, 'IT Manager', 1, 1);

-- Query 1: Find employees who earn more than the average salary and work in IT departments
SELECT e.First_name, e.Last_name, e.Salary
FROM Employee e
JOIN Departments d ON e.Department_id = d.Department_id
WHERE e.Salary > (SELECT AVG(Salary) FROM Employee)
AND d.Department_name = 'IT';

-- Query 2: Find employees who earn the same salary as the minimum salary across all departments
SELECT e.First_name, e.Last_name, e.Salary
FROM Employee e
WHERE e.Salary = (SELECT MIN(Salary) FROM Employee);

-- Query 3: Find employees whose salary is above average for their departments
SELECT e.Employee_id, e.First_name, e.Last_name, e.Salary
FROM Employee e
JOIN Departments d ON e.Department_id = d.Department_id
WHERE e.Salary > (SELECT AVG(Salary) 
                  FROM Employee 
                  WHERE Department_id = e.Department_id);

-- Query 4: Display the department name, manager name, and city
SELECT d.Department_name, m.Manager_name, l.City
FROM Departments d
JOIN Manager m ON d.Manager_id = m.Manager_id
JOIN Locations l ON d.Location_id = l.Location_id;

-- Query 5: Display the name, hire date, salary of all managers whose experience is more than 15 years
SELECT e.First_name, e.Last_name, e.Hire_date, e.Salary
FROM Employee e
JOIN Manager m ON e.Manager_id = m.Manager_id
WHERE e.Job_title LIKE '%Manager%'
AND (SYSDATE - e.Hire_date) / 365 > 15;
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q7
-- Create the Products table
CREATE TABLE Products (
    Product_id NUMBER PRIMARY KEY,
    Product_Name VARCHAR2(100),
    Product_Type VARCHAR2(50),
    Price NUMBER
);

-- Insert sample data into the Products table
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (1, 'Shirt', 'Apparel', 3000);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (2, 'Trousers', 'Apparel', 4000);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (3, 'Laptop', 'Electronics', 70000);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (4, 'Shoes', 'Apparel', 5000);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (5, 'Smartphone', 'Electronics', 25000);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (6, 'Hat', 'Apparel', 1500);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (7, 'Watch', 'Accessories', 6000);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (8, 'Jacket', 'Apparel', 5000);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (9, 'Tablet', 'Electronics', 20000);
INSERT INTO Products (Product_id, Product_Name, Product_Type, Price) VALUES (10, 'Backpack', 'Accessories', 3000);

-- Commit the inserts
COMMIT;

-- PL/SQL Block with all 3 tasks
DECLARE
  -- Variables for task 1 (Parameterized Cursor)
  CURSOR c_apparel_products(p_min_price NUMBER, p_max_price NUMBER) IS
    SELECT Product_id, Product_Name, Product_Type, Price
    FROM Products
    WHERE Product_Type = 'Apparel' AND Price BETWEEN p_min_price AND p_max_price;
    
  v_product_id Products.Product_id%TYPE;
  v_product_name Products.Product_Name%TYPE;
  v_product_type Products.Product_Type%TYPE;  -- Added this variable
  v_price Products.Price%TYPE;

  -- Variables for user input
  v_min_price NUMBER := 2000;  -- Replace with actual user input
  v_max_price NUMBER := 6000;  -- Replace with actual user input

  -- Variables for task 2 (Explicit Cursor)
  CURSOR c_expensive_products IS
    SELECT Product_id, Product_Name, Product_Type, Price
    FROM Products
    WHERE Price > 5000;

  v_exp_product_id Products.Product_id%TYPE;
  v_exp_product_name Products.Product_Name%TYPE;
  v_exp_product_type Products.Product_Type%TYPE;
  v_exp_price Products.Price%TYPE;

BEGIN
  -- Task 1: Parameterized Cursor for Products in Price Range of Type 'Apparel'
  DBMS_OUTPUT.PUT_LINE('--- Products of Type "Apparel" in Price Range ---');
  
  OPEN c_apparel_products(v_min_price, v_max_price);
  
  LOOP
    FETCH c_apparel_products INTO v_product_id, v_product_name, v_product_type, v_price;  -- Match the number of variables
    EXIT WHEN c_apparel_products%NOTFOUND;
    DBMS_OUTPUT.PUT_LINE('Product ID: ' || v_product_id || ', Product Name: ' || v_product_name || ', Type: ' || v_product_type || ', Price: ' || v_price);
  END LOOP;

  CLOSE c_apparel_products;
  
  -- Task 2: Explicit Cursor for Products with Price > 5000
  DBMS_OUTPUT.PUT_LINE('--- Products with Price Greater Than 5000 ---');
  
  OPEN c_expensive_products;

  LOOP
    FETCH c_expensive_products INTO v_exp_product_id, v_exp_product_name, v_exp_product_type, v_exp_price;
    EXIT WHEN c_expensive_products%NOTFOUND;
    DBMS_OUTPUT.PUT_LINE('Product ID: ' || v_exp_product_id || ', Product Name: ' || v_exp_product_name || ', Type: ' || v_exp_product_type || ', Price: ' || v_exp_price);
  END LOOP;

  CLOSE c_expensive_products;
  
  -- Task 3: Implicit Cursor for Updating Prices and Displaying Row Count
  DBMS_OUTPUT.PUT_LINE('--- Updating Prices of All Products by 1000 ---');
  
  UPDATE Products
  SET Price = Price + 1000;

  DBMS_OUTPUT.PUT_LINE('Number of products updated: ' || SQL%ROWCOUNT);

END;
/
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.8
-- Create Customer Table
CREATE TABLE Customer (
    CustID INT PRIMARY KEY,
    Name VARCHAR(50),
    Cust_Address VARCHAR(100),
    Phone_no VARCHAR(15),
    Email_ID VARCHAR(50),
    Age INT
);

-- Create Branch Table
CREATE TABLE Branch (
    Branch_ID INT PRIMARY KEY,
    Branch_Name VARCHAR(50),
    Address VARCHAR(100)
);

-- Create Account Table
CREATE TABLE Account (
    Account_no INT PRIMARY KEY,
    Branch_ID INT,
    CustID INT,
    date_open DATE,
    Account_type VARCHAR(20),
    Balance DECIMAL(15,2),
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID),
    FOREIGN KEY (CustID) REFERENCES Customer(CustID)
);

-- Insert data into Customer table
INSERT INTO Customer (CustID, Name, Cust_Address, Phone_no, Email_ID, Age)
VALUES 
(1, 'tejas', 'Pune', '1234567890', 'tejas@example.com', 30),
(2, 'bhavesh', 'Mumbai', '0987654321', 'bhavesh@example.com', 25),
(3, 'rudra', 'Pune', '1122334455', 'rudra@example.com', 40);

-- Insert data into Branch table
INSERT INTO Branch (Branch_ID, Branch_Name, Address)
VALUES 
(1, 'Main Branch', 'Mumbai'),
(2, 'Pune Branch', 'Pune');

-- Insert data into Account table
INSERT INTO Account (Account_no, Branch_ID, CustID, date_open, Account_type, Balance)
VALUES 
(1001, 1, 1, '2022-01-01', 'Saving Account', 60000),
(1002, 2, 2, '2022-02-01', 'Current Account', 30000),
(1003, 2, 3, '2022-03-01', 'Saving Account', 80000);


-- Modify the size of Email_ID column
ALTER TABLE Customer MODIFY Email_ID VARCHAR(20);

-- Change Email_ID to NOT NULL
ALTER TABLE Customer MODIFY Email_ID VARCHAR(20) NOT NULL;

SELECT COUNT(*) AS Total_Customers
FROM Account
WHERE Balance > 50000;

SELECT AVG(Balance) AS Average_Balance
FROM Account
WHERE Account_type = 'Saving Account';

SELECT * 
FROM Customer
WHERE Cust_Address = 'Pune' OR Name LIKE 'A%';

CREATE TABLE Saving_Account AS
SELECT Account_no, Branch_ID, CustID, date_open, Balance
FROM Account
WHERE Account_type = 'Saving Account';

SELECT Customer.*
FROM Customer
JOIN Account ON Customer.CustID = Account.CustID
WHERE Account.Balance >= 20000
ORDER BY Customer.Age;
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.9

db.Student.insertMany([
    { roll_no: 1, name: "tejas", class: "TE", dept: "Computer", aggregate_marks: 78 },
    { roll_no: 2, name: "bhavesh", class: "TE", dept: "Mechanical", aggregate_marks: 85 },
    { roll_no: 3, name: "rudra", class: "SE", dept: "Electrical", aggregate_marks: 90 },
    { roll_no: 4, name: "anushka", class: "BE", dept: "Computer", aggregate_marks: 70 },
    { roll_no: 5, name: "yumiko", class: "SE", dept: "Mechanical", aggregate_marks: 88 },
    { roll_no: 6, name: "anuja", class: "BE", dept: "Electrical", aggregate_marks: 92 },
    // Add more documents as needed
]);

db.Student.mapReduce(
    function () {
        if (this.class === "TE") {
            emit(this.dept, this.aggregate_marks);
        }
    },
    function (key, values) {
        return Array.sum(values);
    },
    {
        out: "total_marks_TE_class"
    }
);

-- View the results:
db.total_marks_TE_class.find();

db.Student.mapReduce(
    function () {
        if (this.class === "SE") {
            emit(this.dept, this.aggregate_marks);
        }
    },
    function (key, values) {
        return Math.max.apply(null, values);
    },
    {
        out: "highest_marks_SE_class"
    }
);

-- View the results:
db.highest_marks_SE_class.find();

db.Student.mapReduce(
    function () {
        if (this.class === "BE") {
            emit(this.dept, { sum: this.aggregate_marks, count: 1 });
        }
    },
    function (key, values) {
        let total = values.reduce((acc, val) => acc + val.sum, 0);
        let count = values.reduce((acc, val) => acc + val.count, 0);
        return total / count;
    },
    {
        out: "average_marks_BE_class"
    }
);

-- View the results:
db.average_marks_BE_class.find();

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.10

CREATE OR REPLACE TRIGGER trg_no_salary_decrease
BEFORE UPDATE OF salary ON Employee
FOR EACH ROW
BEGIN
    IF :NEW.salary < :OLD.salary THEN
        RAISE_APPLICATION_ERROR(-20001, 'Salary cannot be decreased.');
    END IF;
END trg_no_salary_decrease;
/

CREATE TABLE job_history (
    emp_id NUMBER,
    old_job_title VARCHAR2(50),
    old_dept_id NUMBER,
    start_date DATE,
    end_date DATE
);

CREATE OR REPLACE TRIGGER trg_job_title_change
BEFORE UPDATE OF job_title ON Employee
FOR EACH ROW
BEGIN
    IF :OLD.job_title != :NEW.job_title THEN
        INSERT INTO job_history (emp_id, old_job_title, old_dept_id, start_date, end_date)
        VALUES (:OLD.emp_id, :OLD.job_title, :OLD.dept_id, :OLD.DoJ, SYSDATE);
    END IF;
END trg_job_title_change;
/

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q11
-- Create Customer table
CREATE TABLE Customer (
    CustID INT PRIMARY KEY,
    Name VARCHAR(100),
    Cust_Address VARCHAR(255),
    Phone_no VARCHAR(15),
    Email_ID VARCHAR(100),
    Age INT
);

-- Create Branch table
CREATE TABLE Branch (
    Branch_ID INT PRIMARY KEY,
    Branch_Name VARCHAR(100),
    Address VARCHAR(255)
);

-- Create Account table with foreign key constraints
CREATE TABLE Account (
    Account_no INT PRIMARY KEY,
    Branch_ID INT,
    CustID INT,
    date_open DATE,
    Account_type VARCHAR(50),
    Balance DECIMAL(12, 2),
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID),
    FOREIGN KEY (CustID) REFERENCES Customer(CustID)
);

-- Insert sample data
INSERT INTO Customer (CustID, Name, Cust_Address, Phone_no, Email_ID, Age) 
VALUES (1, 'tejas', '123 Main St', '1234567890', 'tejas@example.com', 30),
       (2, 'bhavesh', '456 Oak St', '2345678901', 'bhavesh@example.com', 50),
       (3, 'rudra', '789 Pine St', '3456789012', 'rudra@example.com', 40);

INSERT INTO Branch (Branch_ID, Branch_Name, Address) 
VALUES (101, 'Downtown', '789 Broadway'),
       (102, 'Uptown', '123 1st Ave');

INSERT INTO Account (Account_no, Branch_ID, CustID, date_open, Account_type, Balance)
VALUES (1001, 101, 1, '2016-03-15', 'Savings', 10000),
       (1002, 102, 2, '2015-05-10', 'Checking', 20000),
       (1003, 101, 3, '2018-07-21', 'Savings', 15000);
CREATE INDEX idx_account_no ON Account(Account_no);
CREATE VIEW Customer_Info AS
SELECT CustID, Name, Cust_Address, Phone_no, Email_ID, Age
FROM Customer
WHERE Age < 45;
UPDATE Account
SET date_open = '2017-04-16'
WHERE CustID IN (SELECT CustID FROM Customer WHERE Age < 45);
CREATE SEQUENCE branch_seq
START WITH 1
INCREMENT BY 1
MINVALUE 1
NOCYCLE;
CREATE SYNONYM Branch_info FOR Branch;

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q12
db.Social_Media.insertMany([
    { User_Id: "U01", User_Name: "A", No_of_Posts: 120, No_of_Friends: 10, Friends_List: ["B", "C", "D"], Interests: ["Music", "Photography"] },
    { User_Id: "U02", User_Name: "B", No_of_Posts: 90, No_of_Friends: 8, Friends_List: ["A", "C"], Interests: ["Cooking", "Sports"] },
    { User_Id: "U03", User_Name: "C", No_of_Posts: 50, No_of_Friends: 5, Friends_List: ["A", "D"], Interests: ["Movies", "Books"] },
    { User_Id: "U04", User_Name: "D", No_of_Posts: 150, No_of_Friends: 12, Friends_List: ["A", "C", "F"], Interests: ["Travel", "Sports"] },
    { User_Id: "U05", User_Name: "E", No_of_Posts: 200, No_of_Friends: 7, Friends_List: ["B", "F"], Interests: ["Fitness", "Books"] },
    { User_Id: "U06", User_Name: "F", No_of_Posts: 75, No_of_Friends: 3, Friends_List: ["D"], Interests: ["Technology", "Gaming"] },
    { User_Id: "U07", User_Name: "G", No_of_Posts: 60, No_of_Friends: 5, Friends_List: ["E", "F"], Interests: ["Photography", "Travel"] },
    { User_Id: "U08", User_Name: "H", No_of_Posts: 300, No_of_Friends: 15, Friends_List: ["D", "G"], Interests: ["Fitness", "Music"] },
    { User_Id: "U09", User_Name: "I", No_of_Posts: 110, No_of_Friends: 6, Friends_List: ["H", "G"], Interests: ["Movies", "Photography"] },
    { User_Id: "U10", User_Name: "J", No_of_Posts: 25, No_of_Friends: 2, Friends_List: ["G"], Interests: ["Sports"] },
    { User_Id: "U11", User_Name: "K", No_of_Posts: 180, No_of_Friends: 9, Friends_List: ["A", "H"], Interests: ["Travel", "Books"] },
    { User_Id: "U12", User_Name: "L", No_of_Posts: 50, No_of_Friends: 4, Friends_List: ["K", "G"], Interests: ["Technology", "Gaming"] },
    { User_Id: "U13", User_Name: "M", No_of_Posts: 210, No_of_Friends: 13, Friends_List: ["K", "I"], Interests: ["Fitness", "Music"] },
    { User_Id: "U14", User_Name: "N", No_of_Posts: 80, No_of_Friends: 6, Friends_List: ["M", "I"], Interests: ["Movies", "Sports"] },
    { User_Id: "U15", User_Name: "O", No_of_Posts: 55, No_of_Friends: 4, Friends_List: ["K", "G"], Interests: ["Technology"] },
    
]);
db.Social_Media.find({}, { User_Id: 1, User_Name: 1, No_of_Posts: 1, No_of_Friends: 1, _id: 0 }).pretty();
db.Social_Media.find({ No_of_Posts: { $gt: 100 } }, { User_Name: 1, No_of_Posts: 1, _id: 0 }).pretty();
db.Social_Media.find({}, { User_Name: 1, Friends_List: 1, _id: 0 }).pretty();
db.Social_Media.find({ No_of_Friends: { $gt: 5 } }, { User_Id: 1, Friends_List: 1, _id: 0 }).pretty();
db.Social_Media.find({}, { User_Name: 1, No_of_Posts: 1, _id: 0 }).sort({ No_of_Posts: -1 }).pretty();
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.13

DECLARE
    CURSOR emp_cursor IS
        SELECT Emp_id, Emp_Name, Salary
        FROM Employee
        WHERE Salary > 50000;
    emp_record Employee%ROWTYPE;
BEGIN
    OPEN emp_cursor;
    LOOP
        FETCH emp_cursor INTO emp_record;
        EXIT WHEN emp_cursor%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('Emp ID: ' || emp_record.Emp_id || 
                             ', Name: ' || emp_record.Emp_Name || 
                             ', Salary: ' || emp_record.Salary);
    END LOOP;
    CLOSE emp_cursor;
END;
/

DECLARE
    total_count NUMBER;
BEGIN
    SELECT COUNT(*) INTO total_count FROM Employee;
    DBMS_OUTPUT.PUT_LINE('Total number of employees: ' || total_count);
END;
/

DECLARE
    emp_id_input Employee.Emp_id%TYPE;
    CURSOR salary_cursor (p_emp_id Employee.Emp_id%TYPE) IS
        SELECT Salary FROM Employee WHERE Emp_id = p_emp_id;
    emp_salary Employee.Salary%TYPE;
BEGIN
    -- Replace 101 with the employee ID you want to look up
    emp_id_input := &emp_id_input;

    OPEN salary_cursor(emp_id_input);
    FETCH salary_cursor INTO emp_salary;
    
    IF salary_cursor%FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Salary of employee ID ' || emp_id_input || ' is: ' || emp_salary);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Employee with ID ' || emp_id_input || ' not found.');
    END IF;

    CLOSE salary_cursor;
END;
/
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q14
-- Create the Locations table
CREATE TABLE Locations (
    location_id INT PRIMARY KEY,
    street_address VARCHAR(255),
    postal_code VARCHAR(20),
    city VARCHAR(100),
    state VARCHAR(100),
    country_id VARCHAR(2)
);

-- Create the Manager table
CREATE TABLE Manager (
    Manager_id INT PRIMARY KEY,
    Manager_name VARCHAR(100)
);

-- Create the Departments table with a foreign key for Manager
CREATE TABLE Departments (
    Department_id INT PRIMARY KEY,
    Department_name VARCHAR(100),
    Manager_id INT,
    Location_id INT,
    FOREIGN KEY (Manager_id) REFERENCES Manager(Manager_id),
    FOREIGN KEY (Location_id) REFERENCES Locations(location_id)
);

-- Create the Employee table with foreign keys for Department and Manager
CREATE TABLE Employee (
    Employee_id INT PRIMARY KEY,
    First_name VARCHAR(100),
    Last_name VARCHAR(100),
    hire_date DATE,
    salary DECIMAL(10, 2),
    Job_title VARCHAR(50),
    manager_id INT,
    department_id INT,
    FOREIGN KEY (manager_id) REFERENCES Manager(Manager_id),
    FOREIGN KEY (department_id) REFERENCES Departments(Department_id)
);
SELECT e.First_name, e.Last_name, e.salary
FROM Employee e
WHERE e.salary > (SELECT salary FROM Employee WHERE Last_name = 'Singh');
SELECT e.First_name, e.Last_name
FROM Employee e
JOIN Departments d ON e.department_id = d.Department_id
JOIN Locations l ON d.Location_id = l.location_id
WHERE e.manager_id IS NOT NULL
AND l.country_id = 'US';
SELECT e.First_name, e.Last_name, e.salary
FROM Employee e
WHERE e.salary > (SELECT AVG(salary) FROM Employee);
SELECT e.Employee_id, e.Last_name AS Employee_name, e.manager_id, m.Last_name AS Manager_name
FROM Employee e
JOIN Employee m ON e.manager_id = m.Employee_id;
SELECT e.First_name, e.Last_name, e.hire_date
FROM Employee e
WHERE e.hire_date > (SELECT hire_date FROM Employee WHERE Last_name = 'Jones');

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
@15
db.Book.insertMany([
  { Title: "Book A", Author_name: "Author 1", Borrowed_status: true, Price: 250 },
  { Title: "Book B", Author_name: "Author 1", Borrowed_status: false, Price: 320 },
  { Title: "Book C", Author_name: "Author 2", Borrowed_status: true, Price: 450 },
  { Title: "Book D", Author_name: "Author 3", Borrowed_status: false, Price: 150 },
  { Title: "Book E", Author_name: "Author 2", Borrowed_status: true, Price: 500 }
]);
var mapFunction1 = function () {
    emit(this.Author_name, this.Title);
};
var reduceFunction1 = function (key, values) {
    return values;
};
db.Book.mapReduce(
    mapFunction1,
    reduceFunction1,
    { out: "author_books" }
);

// To see the results
db.author_books.find().pretty();
var mapFunction2 = function () {
    if (this.Borrowed_status === true) {
        emit(this.Author_name, this.Title);
    }
};
var reduceFunction2 = function (key, values) {
    return values;
};
db.Book.mapReduce(
    mapFunction2,
    reduceFunction2,
    { out: "borrowed_books_by_author" }
);

// To see the results
db.borrowed_books_by_author.find().pretty();
var mapFunction3 = function () {
    if (this.Price > 300) {
        emit(this.Author_name, this.Title);
    }
};
var reduceFunction3 = function (key, values) {
    return values;
};
db.Book.mapReduce(
    mapFunction3,
    reduceFunction3,
    { out: "expensive_books_by_author" }
);

// To see the results
db.expensive_books_by_author.find().pretty();
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.16

CREATE OR REPLACE PROCEDURE calculate_commission IS
    CURSOR emp_cursor IS 
        SELECT emp_id, salary, DoJ 
        FROM Employee;
    emp_record emp_cursor%ROWTYPE;
    years_experience NUMBER;
BEGIN
    FOR emp_record IN emp_cursor LOOP
        -- Calculate experience in years based on DoJ
        years_experience := FLOOR(MONTHS_BETWEEN(SYSDATE, emp_record.DoJ) / 12);
        
        -- Determine commission based on the conditions provided
        IF emp_record.salary > 10000 THEN
            UPDATE Employee SET commission = emp_record.salary * 0.004 WHERE emp_id = emp_record.emp_id;
        ELSIF emp_record.salary < 10000 AND years_experience > 10 THEN
            UPDATE Employee SET commission = emp_record.salary * 0.0035 WHERE emp_id = emp_record.emp_id;
        ELSIF emp_record.salary < 3000 THEN
            UPDATE Employee SET commission = emp_record.salary * 0.0025 WHERE emp_id = emp_record.emp_id;
        ELSE
            UPDATE Employee SET commission = emp_record.salary * 0.0015 WHERE emp_id = emp_record.emp_id;
        END IF;
    END LOOP;
    COMMIT;
END calculate_commission;
/


2)-- Sample Department table
CREATE TABLE Department (
    dept_id NUMBER PRIMARY KEY,
    manager_id NUMBER,
    FOREIGN KEY (manager_id) REFERENCES Employee(emp_id)
);

CREATE OR REPLACE FUNCTION get_manager_name(p_dept_id NUMBER) RETURN VARCHAR2 IS
    v_manager_name Employee.emp_name%TYPE;
BEGIN
    SELECT emp_name INTO v_manager_name
    FROM Employee e
    JOIN Department d ON e.emp_id = d.manager_id
    WHERE d.dept_id = p_dept_id;

    RETURN v_manager_name;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        RETURN 'Manager not found';
END get_manager_name;
/

BEGIN
    calculate_commission;
END;
/

DECLARE
    manager_name VARCHAR2(50);
BEGIN
    manager_name := get_manager_name(10);  -- Replace 10 with the actual department ID
    DBMS_OUTPUT.PUT_LINE('Manager Name: ' || manager_name);
END;
/
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.17

-- Create Customer Table
CREATE TABLE Customer (
    CustID INT PRIMARY KEY,
    Name VARCHAR(50),
    Cust_Address VARCHAR(100),
    Phone_no VARCHAR(15),
    Age INT
);

-- Create Branch Table
CREATE TABLE Branch (
    Branch_ID INT PRIMARY KEY,
    Branch_Name VARCHAR(50),
    Address VARCHAR(100)
);

-- Create Account Table
CREATE TABLE Account (
    Account_no INT PRIMARY KEY,
    Branch_ID INT,
    CustID INT,
    date_open DATE,
    Account_type VARCHAR(20),
    Balance DECIMAL(15,2),
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID),
    FOREIGN KEY (CustID) REFERENCES Customer(CustID)
);

-- Insert sample data into Customer table
INSERT INTO Customer (CustID, Name, Cust_Address, Phone_no, Age)
VALUES 
(1, 'tejas', 'Pune', '1234567890', 40),
(2, 'bhavesh', 'Mumbai', '0987654321', 28),
(3, 'rudra', 'Pune', '1122334455', 45);

-- Insert sample data into Branch table
INSERT INTO Branch (Branch_ID, Branch_Name, Address)
VALUES 
(1, 'Main Branch', 'Mumbai'),
(2, 'Pune Branch', 'Pune');

-- Insert sample data into Account table
INSERT INTO Account (Account_no, Branch_ID, CustID, date_open, Account_type, Balance)
VALUES 
(1001, 1, 1, '2022-01-01', 'Saving Account', 60000),
(1002, 2, 2, '2022-02-01', 'Current Account', 30000),
(1003, 2, 3, '2022-03-01', 'Saving Account', 25000);


ALTER TABLE Customer ADD Email_Address VARCHAR(50);


ALTER TABLE Customer CHANGE Email_Address Email_ID VARCHAR(50);


SELECT Customer.*
FROM Customer
JOIN Account ON Customer.CustID = Account.CustID
ORDER BY Account.Balance DESC
LIMIT 1;


SELECT Customer.*
FROM Customer
JOIN Account ON Customer.CustID = Account.CustID
WHERE Account.Account_type = 'Saving Account'
ORDER BY Account.Balance ASC
LIMIT 1;


SELECT *
FROM Customer
WHERE Cust_Address = 'Pune' AND Age > 35;


SELECT CustID, Name, Age
FROM Customer
ORDER BY Age ASC;


SELECT Customer.Name, Account.Branch_ID, Account.Account_type
FROM Customer
JOIN Account ON Customer.CustID = Account.CustID
GROUP BY Account.Account_type, Customer.Name, Account.Branch_ID;


-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q18
db.Student_Data.insertMany([
    { Student_ID: "S01", Student_Name: "A", Department: "Computer Science", Marks: 85 },
    { Student_ID: "S02", Student_Name: "B", Department: "Computer Science", Marks: 90 },
    { Student_ID: "S03", Student_Name: "C", Department: "Mathematics", Marks: 78 },
    { Student_ID: "S04", Student_Name: "D", Department: "Mathematics", Marks: 88 },
    { Student_ID: "S05", Student_Name: "E", Department: "Physics", Marks: 92 },
    { Student_ID: "S06", Student_Name: "F", Department: "Physics", Marks: 76 },
    { Student_ID: "S07", Student_Name: "G", Department: "Computer Science", Marks: 65 },
    { Student_ID: "S08", Student_Name: "H", Department: "Mathematics", Marks: 70 },
    { Student_ID: "S09", Student_Name: "I", Department: "Physics", Marks: 85 },
    { Student_ID: "S10", Student_Name: "J", Department: "Computer Science", Marks: 95 }
]);
db.Student_Data.aggregate([
    {
        $group: {
            _id: "$Department",
            averageMarks: { $avg: "$Marks" },
            students: { $push: { Student_ID: "$Student_ID", Student_Name: "$Student_Name", Marks: "$Marks" } }
        }
    },
    {
        $project: {
            Department: "$_id",
            averageMarks: 1,
            students: 1,
            _id: 0
db.        }
    }
]).pretty();
db.Student_Data.aggregate([
    {
        $group: {
            _id: "$Department",
            numberOfStudents: { $sum: 1 }
        }
    },
    {
        $project: {
            Department: "$_id",
            numberOfStudents: 1,
            _id: 0
        }
    }
]).pretty();
db.Student_Data.aggregate([
    {
        $sort: { Marks: -1 }
    },
    {
        $group: {
            _id: "$Department",
            highestMarksStudent: { $first: "$$ROOT" }
        }
    },
    {
        $project: {
            Department: "$_id",
            Student_ID: "$highestMarksStudent.Student_ID",
            Student_Name: "$highestMarksStudent.Student_Name",
            Marks: "$highestMarksStudent.Marks",
            _id: 0
        }
    }
]).pretty();
db.Student_Data.createIndex({ Student_ID: 1 });
db.Student_Data.createIndex({ Student_Name: 1, Department: 1 });
db.Student_Data.dropIndex({ Student_ID: 1 });
db.Student_Data.dropIndex({ Student_Name: 1, Department: 1 });

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.19

DECLARE
    v_emp_id Employee.emp_id%TYPE := &emp_id; -- Accepting emp_id from the user
    v_salary Employee.salary%TYPE;
    v_new_salary Employee.salary%TYPE;
    v_experience NUMBER;
    salary_increased EXCEPTION; -- User-defined exception for successful salary update

BEGIN
    -- Retrieve the current salary and calculate the experience in years
    SELECT salary, FLOOR(MONTHS_BETWEEN(SYSDATE, DoJ) / 12) INTO v_salary, v_experience
    FROM Employee
    WHERE emp_id = v_emp_id;

    -- Determine the new salary based on experience
    IF v_experience > 10 THEN
        v_new_salary := v_salary * 1.20;
    ELSIF v_experience > 5 THEN
        v_new_salary := v_salary * 1.10;
    ELSE
        v_new_salary := v_salary * 1.05;
    END IF;

    -- Update the Salary_Increment table with the new salary
    INSERT INTO Salary_Increment (emp_id, new_salary)
    VALUES (v_emp_id, v_new_salary);

    -- Raise a user-defined exception to indicate the salary increase was successful
    RAISE salary_increased;

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Error: Employee with ID ' || v_emp_id || ' does not exist.');

    WHEN salary_increased THEN
        DBMS_OUTPUT.PUT_LINE('Salary updated successfully for Employee ID ' || v_emp_id);
        DBMS_OUTPUT.PUT_LINE('New Salary: ' || v_new_salary);

    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('An unexpected error occurred: ' || SQLERRM);

END;
/
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q.20

-- Create Customer Table
CREATE TABLE Customer (
    CustID INT PRIMARY KEY,
    Name VARCHAR(50),
    Cust_Address VARCHAR(100),
    Phone_no VARCHAR(15),
    Email_ID VARCHAR(50),
    Age INT
);

-- Create Branch Table
CREATE TABLE Branch (
    Branch_ID INT PRIMARY KEY,
    Branch_Name VARCHAR(50),
    Address VARCHAR(100)
);

-- Create Account Table with Foreign Key Constraints
CREATE TABLE Account (
    Account_no INT PRIMARY KEY,
    Branch_ID INT,
    CustID INT,
    open_date DATE,
    Account_type VARCHAR(20),
    Balance DECIMAL(15,2),
    FOREIGN KEY (Branch_ID) REFERENCES Branch(Branch_ID),
    FOREIGN KEY (CustID) REFERENCES Customer(CustID)
);

INSERT INTO Customer (CustID, Name, Cust_Address, Phone_no, Email_ID, Age)
VALUES 
(101, 'tejas', 'Mumbai', '1234567890', 'tejas@example.com', 30),
(102, 'bhavesh', 'Pune', '0987654321', 'bhavesh@example.com', 40),
(103, 'rudra', 'Delhi', '1122334455', 'rudra@example.com', 25);

INSERT INTO Branch (Branch_ID, Branch_Name, Address)
VALUES 
(1, 'Main Branch', 'Mumbai'),
(2, 'Pune Branch', 'Pune');

INSERT INTO Account (Account_no, Branch_ID, CustID, open_date, Account_type, Balance)
VALUES 
(1001, 1, 101, '2018-08-16', 'Saving', 50000),
(1002, 2, 102, '2018-02-16', 'Loan', 100000),
(1003, 2, 103, '2018-08-16', 'Saving', 30000);


CREATE VIEW Saving_account AS
SELECT Customer.CustID, Customer.Name, Customer.Cust_Address, Customer.Phone_no, Customer.Email_ID, Customer.Age, Account.open_date, Account.Balance
FROM Customer
JOIN Account ON Customer.CustID = Account.CustID
WHERE Account.Account_type = 'Saving' AND Account.open_date = '2018-08-16';


UPDATE Customer
SET Cust_Address = 'Pune'
WHERE CustID = 103;


CREATE VIEW Loan_account AS
SELECT Customer.CustID, Customer.Name, Customer.Cust_Address, Customer.Phone_no, Customer.Email_ID, Customer.Age, Account.open_date, Account.Balance
FROM Customer
JOIN Account ON Customer.CustID = Account.CustID
WHERE Account.Account_type = 'Loan' AND Account.open_date = '2018-02-16';


CREATE INDEX idx_customer_id ON Customer (CustID);


CREATE INDEX idx_branch_id ON Branch (Branch_ID);

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Q21
db.Student.insertMany([
  { Roll_No: "A01", Name: "J", Class: "SE", Marks: 65, Address: "Street 1", Enrolled_Courses: ["DBMS", "OS"] },
  { Roll_No: "A02", Name: "A", Class: "TE", Marks: 75, Address: "Street 2", Enrolled_Courses: ["TOC", "AI"] },
  { Roll_No: "A03", Name: "B", Class: "TE", Marks: 85, Address: "Street 3", Enrolled_Courses: ["DBMS", "TOC"] },
  { Roll_No: "A04", Name: "C", Class: "SE", Marks: 40, Address: "Street 4", Enrolled_Courses: ["AI"] },
  { Roll_No: "A05", Name: "D", Class: "BE", Marks: 60, Address: "Street 5", Enrolled_Courses: ["DBMS", "ML"] },
  { Roll_No: "A06", Name: "E", Class: "BE", Marks: 30, Address: "Street 6", Enrolled_Courses: ["TOC"] },
  { Roll_No: "A07", Name: "F", Class: "SE", Marks: 45, Address: "Street 7", Enrolled_Courses: ["OS", "DBMS"] },
  { Roll_No: "A08", Name: "G", Class: "TE", Marks: 95, Address: "Street 8", Enrolled_Courses: ["DBMS", "TOC"] },
  { Roll_No: "A09", Name: "H", Class: "SE", Marks: 50, Address: "Street 9", Enrolled_Courses: ["OS", "DBMS"] },
  { Roll_No: "A10", Name: "I", Class: "BE", Marks: 55, Address: "Street 10", Enrolled_Courses: ["AI", "DBMS"] }
]);

db.Student.find({
  Enrolled_Courses: { $all: ["DBMS", "TOC"] }
}, { Name: 1, _id: 0 });

db.Student.find({
  $or: [
    { Marks: { $gt: 50 } },
    { Class: "TE" }
  ]
}, { Roll_No: 1, Class: 1, _id: 0 });
db.Student.updateOne(
  { Roll_No: "A10" },
  {
    $set: {
      Name: "Ivy Updated",
      Class: "BE",
      Marks: 75,
      Address: "Updated Street",
      Enrolled_Courses: ["AI", "ML"]
    }
  }
);
db.Student.find({}, { Name: 1, Marks: 1, _id: 0 })
  .sort({ Marks: -1 })
  .skip(2)
  .limit(2);
db.Student.deleteMany({ Marks: { $lt: 20 } });
db.Student.deleteOne({});
------------------------------------------------------------------------------------------------------------------