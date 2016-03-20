特色数据库文章
Featured Database Articles

SQL等

在HTML 5使用​​Web SQL数据库API

By Yuvarani Meiyappan


One of the HTML 5 specifications, Web SQL database, enables offline data storage by defining an API for storing structured data within the client. Yuvarani Meiyappan introduces the new Web SQL database feature in HTML5 and its API, and then dives into using Web SQL database with a demo for implementing a shopping cart.

一个HTML 5规范(specifications)，网络SQL数据库，使得能够离线数据存储(storage)定义的API客户端中存储的结构化数据。瓦拉尼Meiyappan引入了新的Web SQL数据库功能的HTML5和它的API，然后潜入使用Web SQL数据库的演示实现了购物车。

The HTML 5 specification has introduced a number of new elements, attributes and APIs to increase the quality, speed and richness of Web applications, and a few browsers including Google Chrome have already implemented many of these exciting features. One of the HTML 5 specifications, Web SQL database enables offline data storage by defining an API for storing structured data within the client.

在HTML 5规范已经推出了许多新的元素，属性和API，以提高质量，速度和Web应用程序的丰富性，以及一些浏览器，包括谷歌Chrome浏览器已经实现了许多这些令人兴奋的功能。一个HTML 5规范，网络SQL数据库实现离线数据存储定义的API客户端中存储的结构化数据。

nlike HTML 5's Web Storage API, which persists data in key-value pairs on the client, the Web SQL database persists the data in a database on the client. The Web SQL database is asynchronous and can be queried and manipulated using the API through JavaScript.

与HTML 5的Web存储API，它仍然存在于客户端上的键-值对的数据，在Web SQL数据库仍然存在于客户机上的数据库中的数据。在Web SQL数据库是异步的，可以查询并使用通过JavaScript API的操作。

In this article, I introduce the new Web SQL database feature in HTML5 and its API. We then dive into using Web SQL database with a demo for implementing a shopping cart.

在这篇文章中，我将介绍在HTML5和它的API新的Web SQL数据库的功能。然后，我们深入到使用Web SQL数据库的演示实现了购物车。

The Interfaces of the Web SQL Database API

在Web SQL数据库API的接口

In this section, we explore some of the interfaces and methods that are available in the Web SQL database API.

在本节中，我们将探讨一些是Web SQL数据库API中提供的接口和方法。

Database API
数据库API

The Database API of Web SQL database has the WindowDatabase and WorkerUtils interfaces. The interfaces have the openDatabase() method, which creates the database within the browser. If the user agent is not configured to allow the page to open the database locally, the openDatabase method will result in a SECURITY_ERR exception. If there is no database with the given name, then the openDatabase method will create a new database.

了Web SQL数据库的数据库API具有WindowDatabase和WorkerUtils接口。所述接口具有的openDatabase（）方法，它创建浏览器内的数据库。如果用户代理未配置为允许网页局部打开数据库，OpenDatabase方法将导致SECURITY_ERR异常。如果给定名称没有数据库，然后OpenDatabase方法将创建一个新的数据库。

Here is the syntax:
下面是语法：

Database openDatabase(databaseName, databaseVersion, displayName, 
estimatedSizeOfDataInBytes, databaseCreationFailureCallback) 

Here is a code example:

              var shortName = 'productdatabase';
              var version = '1.0';
              var displayName = 'Product Database';
              var maxSize = 65536; // in bytes
              db = openDatabase(shortName, version, displayName, maxSize);

 The last statement in the above code would create a database.            

Asynchronous Database API
异步数据库API

The Asynchronous database API has an interface called Database. The Database interface has the transaction and readTransaction methods, which take up to three arguments. The transaction method opens the database in read/write mode, whereas the readTransaction method opens the database in read mode.

异步数据库API有一个名为数据库的接口。数据库接口具有transaction和readTransaction方法，这需要长达三个参数。本次交易方法打开的读/写模式的数据库，而readTransaction方法打开在读模式下的数据库。

Here is the syntax:
下面是语法：

void transaction(sqlTransactionCallback, transactionErrorCallback, transactionSuccessCallback)

void readTransaction(sqlTransactionCallback, transactionErrorCallback, transactionSuccessCallback)


Because the method is asynchronous, it would immediately return and then asynchronously invoke sqlTransactionCallback. Based on the result of sqlTransactionCallback, transactionErrorCallback or transactionSuccessCallback would be executed.

由于该方法是异步的，它会立即返回，然后异步调用sqlTransactionCallback。基于sqlTransactionCallback，transactionErrorCallback或transactionSuccessCallback的结果将被执行。

Here is a code example:

      db.transaction(
         function (transaction) {
            transaction.executeSql('CREATE TABLE IF NOT EXISTS Product(productid INTEGER NOT 
NULL PRIMARY KEY AUTOINCREMENT, productname TEXT NOT NULL, price INTEGER, qoh
 INTEGER);', [], nullDataHandler, killTransaction);
         }
      ); 

In the above code, the transaction is invoked by defining only sqlTransactionCallback. The code does not have either transactionErrorCallback or transactionSuccessCallback in it.

在上面的代码中，事务是通过定义仅sqlTransactionCallback调用。该代码没有任何transactionErrorCallback或transactionSuccessCallback在里面。

executeSql
的ExecuteSQL

The executeSql method should be invoked as part of sqlTransactionCallback, transactionErrorCallback or transactionSuccessCallback of transaction or readTransaction.

该方法的ExecuteSQL应该调用为sqlTransactionCallback，transactionErrorCallback或交易或readTransaction的transactionSuccessCallback的一部分。

Here is the syntax:

void executeSql(sqlStatement, argumentsWithinSquareBrackets, sqlStatementCallback,
 sqlStatementErrorCallback)


 The sqlStatement in the executeSql argument would be preprocessed using arugmentsWithinSquareBrackets.

在论证的ExecuteSQL在SQLStatement将使用arugmentsWithinSquareBrackets进行预处理。

Here is a code example:

transaction.executeSql("INSERT INTO product values(?,?,?,?);",[ productId,
 productName, price , qoh ], nullDataHandler, killTransaction);

The nullDataHandler and the killTransaction are the sqlStatementCallback and sqlStatementErrorCallback functions, respectively.

的nullDataHandler和killTransaction是sqlStatementCallback和sqlStatementErrorCallback功能分别。

 /* This is the data handler which would be null in case of table creation and record insertion 这是数据处理这将是无效的情况下创建表和插入记录的*/
   function nullDataHandler(transaction, results)   {
   }
   /* This is the error handler这是错误处理 */
   function killTransaction(transaction, error) {
   }


Synchronous Database API
同步数据库API

The Synchronous database API has the interface DatabaseSync, which has the transaction and readtransaction methods.

同步数据库API具有接口DatabaseSync，它具有事务和readtransaction方法。

Here is the syntax:

void transaction(sqlTransactionSyncCallback)
void readTransaction(sqlTransactionSyncCallback)

Because the method is synchronous, the method would be executed immediately.
因为该方法是同步的，该方法将被立即执行。

下面是语法的ExecuteSQL：

SQLResultSet的ExecuteSQL（的SQLStatement，argumentsWithinSquareBrackets）

Database Query Results API
数据库查询结果的API

The database query results API has the interface SQLResultSet. A successful execution with the executeSql method would invoke sqlStatmentCallback with SQLResultSet as an argument.

数据库查询的结果API具有接口SQLResultSet。成功执行的方法的ExecuteSQL将调用sqlStatmentCallback与SQLResultSet作为参数。

SQLResultSet has three attributes for insertRowId, rowsAffected and rows.
SQLResultSet具有用于insertRowId，的RowsAffected和行三种属性。

When the corresponding executeSql inserts a record into the table, the insertRow would reflect the row ID of the last row to be inserted into the table. If the corresponding executeSql is affecting any records, because of operations such as update or delete, rowsAffected would reflect the number of rows being affected.

当相应的ExecuteSQL将记录插入该表中，的insertRow将反映最后一行的行的ID要插入到表中。如果相应的ExecuteSQL是影响任何记录，因为操作的，如更新或删除，将的RowsAffected反映受影响的行数。

The rows (third attribute) of type SQLResultSetRowList has length and item.
类型SQLResultSetRowList的行（第三个属性）的长度和项目。

As an example, consider the following code to understand the usage of SQLResultSet and SQLResultSetRowList.

作为一个例子，考虑下面的代码来了解SQLResultSet和SQLResultSetRowList的使用。

       t transaction.executeSql('select * from product where productId=?;', [productId],
          function(transaction, results){
      for (var j=0; j<results.rows.length; j++) {
        var row = results.rows.item(j);
        alert(row[‘productId’]);
      }
         });

In the above code, executeSql has an inbuilt sqlStatmentCallback. The callback method takes two arguments, namely transaction and results. Results is of type SQLResultSet, so results.row.length would return the length of the SQLResultSet. The product details from the result set can be retrieved by using results.rows.item(j) as demonstrated in the above code.

在上面的代码，拥有的ExecuteSQL一个内置sqlStatmentCallback。回调方法有两个参数，即交易和结果。结果是类型SQLResultSet，所以results.row.length将返回SQLResultSet的长度。从结果集产品的详细信息可以通过检索results.rows.item（J）作为展示在上面的代码。


Implementation of Shopping Cart Using Web SQL Database
购物车实施使用Web SQL数据库

In this section, we walk through implementing a shopping cart application. When requested, the Web application will send the details of the products available to the client. To reduce the interaction between the client and the server, the client should store the details of the products, which include product ID, product name, qoh (quantity on hand), and price.

在本节中，我们通过实施一个购物车应用程序走。当请求时，Web应用程序将发送提供给客户的产品的细节。为了减少客户端与服务器之间的交互，客户端应存储的产品，其中包括产品ID，产品名称，QOH（库存量），以及价格的细节。

When the user selects a particular product, the validation for the availability of the required quantity is carried out on the client. If the required quantity is not available, the application will pop up an alert. If the required quantity is available, the product will be added on to the local session variable, which acts as the shopping cart (see Figure 1).

当用户选择一个特定的产品，该验证所需要的数量的情况下进行的客户端上。如果需要的量不可用，应用程序会弹出一个警告。如果所需的量是可用的，该产品将被添加到本地会话变量，其作为购物车（见图1）。


在HTML 5的Web SQL数据库API
图1.购物篮产品详细信息

When the user confirms for billing, the products available in the local session variable can be further processed.
当用户确认进行计费，在本地会话变量所提供产品可被进一步处理。

这里要对这个问题实现的步骤：

Here are the procedures to be implemented for the problem:

When loaded into the browser, the page should create a Web SQL database on the client to store the product details sent by the server.
The page should create a table within the Web SQL database to store the product details from the server and load them into the table.
The page should display the list of products available to the user.
When the user selects the products and clicks the "Shop" button, the products selected -- along with the quantity required -- should be validated against the quantity available in the local database. If the required quantity is available, the product ID and the required quantity of all the chosen products should be stored in the Web storage session variable.
The code to implement the above steps is explained below.

当加载到浏览器时，页面应当在客户端上创建Web SQL数据库存储由服务器发送的产品信息。
该页面应该在Web SQL数据库中创建一个表来存储从服务器产品的详细信息并将其加载到表中。
页面应显示提供给用户的产品清单。
当用户选择的产品和点击“商店”按钮，选定的产品 - 以及所需的量 - 应该对在本地数据库中可用的数量进行验证。如果所需的量是可用的，产品ID和所需的所有所选择的产品数量应存储在Web存储会话变量。
实施上述步骤的代码进行说明。

步骤1

下面的代码验证浏览器是否支持Web SQL数据库。如果是这样，代码使用OpenDatabase方法来创建一个名称的数据库productdatabase。

The code below validates whether the browser supports the Web SQL database. If it does, the code uses the openDatabase method to create a database with the name productdatabase.

<script>
var db;
   function initDB()
   {
      try {
          if (!window.openDatabase) {
              alert('not supported');
          } else {
              var shortName = 'productdatabase';
              var version = '1.0';
              var displayName = 'Product Database';
              var maxSize = 65536; // in bytes
              db = openDatabase(shortName, version, displayName, maxSize);
              // invoke the createTables function explained below
          }
      } catch(e) {
          // Error handling 
          alert("Error creating the database");
      }
}

The initDB in the above given script should be invoked during onload of the <body> of the page.

在initdb的在上面给出的脚本应该在的onload过程中被调用的<body>页面。

第2步

下面的代码创建表来存储服务器提供产品的详细信息。

The code below creates the table to store the product details provided by the server.


   function createTables(db)   {
      // creates the product table to store the product details
      db.transaction(
         function (transaction) {
            transaction.executeSql('CREATE TABLE IF NOT EXISTS Product
      (productid INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, 
      productname TEXT NOT NULL, 
      price INTEGER, qoh INTEGER);',
       [], nullDataHandler, killTransaction);
         }
      );

      // populates the product details in to the Web storage
      db.transaction(
        function (transaction) {
          // retrieve product details from the server 
    /* the below given code retrieve the product details from productList which is an 
         Arraylist available within the same JSP ! */
          <%
         for(int i=0;i<productList.size();i++){
          %>
         var productId = <%=productList.get(i).getProductId()%>;
         var productName = '<%=productList.get(i).getProductName()%>';
         var price = <%=productList.get(i).getPrice()%>;
         var qoh = <%=productList.get(i).getQoh()%>;
         transaction.executeSql("INSERT INTO product values(?,?,?,?);",[ productId, 
            productName, price , qoh ], nullDataHandler, killTransaction);
          <%
         }
          %>
        }
      );
    }

The method createTables should be invoked from the initDB given under step 1 when the database is created successfully.

该方法createTables应该从initdb的调用时，在成功创建数据库步骤1中给出。

第3步

下面的代码是用于显示可用来动态用户产品清单。该产品列表的类型的ArrayList <产品>，其中该产品具有产品ID，产品名称，价格，库存量。

    The code below is for displaying the list of products available to the user dynamically. The productList is of type ArrayList<Product>, where the Product has productId, productName, price, qoh.

      <table>
      <%
         for(int i=0;i<productList.size();i++){
      %>
      <tr>
      <td><input type='checkbox' 
      value='<%=productList.get(i).getProductId()%>' 
    name='product'><%=productList.get(i).getProductName() %></td>
      <td><input type="text" name="p"+<%=productList.get(i).getProductId()%> /></td>
      </tr>
      <%
         }
      %>   
      </table>
      <table>
            <tr>
            <td>         
               <input value="Shop" type="submit" onclick="return productValidation();"/>
            </td>
            </tr>
      </table>
步骤4a

按钮的onclick调用productValidation（）函数。又将productValidation函数调用checkProducts功能如下所示。

   The onclick of the button invokes the productValidation() function. The productValidation function in turn invokes the checkProducts function as shown below.

   function productValidation(){
       checkProducts(document.Products.product, 0);
       return false; 
   }

   function checkProducts(products, i){
     var db = systemDB;
     if (i<products.length){
         if (document.Products.product[i].checked==true){
         productId = document.Products.product[i].value;
         qty = document.Products.p[i].value;

     db.transaction(
     function(transaction){
       transaction.executeSql('select * from product where productId=?;', [productId],
          function(transaction, results){
      for (var j=0; j<results.rows.length; j++) {
        var row = results.rows.item(j);
        if (qty>row['qoh']){
          alert(row['productname'] + ' is out of stock. We can serve you only ' + row['qoh'] + ' 
quantities currently!');
          document.Products.product[i].checked = false;
          document.Products.p[i].value = "";
        }
        else{
          document.Products.product[i].checked = false;
           document.Products.p[i].value = "";
          pId = productId;
          pQty = qty;
          pName = row['productname']; 
          updateProduct();
      }
               }
              checkProductsSequential(products,i+1);
         });
       }
     );
    }
    else{
     checkProducts (products,i+1);         
    }
}
}

The checkProducts method uses the asynchronous method of the Web SQL storage API. It is important to make sure that the validations happen one product after the other.

该checkProducts方法使用Web SQL存储API的异步方法。确保后，其他的校验发生一个产品是非常重要的。

步骤4b

如果所需的量是可用的，该产品和所要求的数量应添加到Web存储和手头（QOH）的数量应相应地更新。该功能的UpdateProduct提供此功能。

   If the required quantity is available, the product and the quantity required should be added on to the Web storage and the quantity on hand (qoh) should be updated accordingly. The updateProduct function delivers this functionality.

   function updateProduct(){

      db.transaction(
         function (transaction) {
            transaction.executeSql("UPDATE PRODUCT SET qoh=qoh-? 
        WHERE productid=?;",[pQty,pId], nullDataHandler, killTransaction);
         }
      );
      var qty = sessionStorage.getItem(pName);
      if (qty){
         sessionStorage.removeItem(pName);
         sessionStorage.setItem(pName,(Number(qty)+Number(pQty)));   
      }
      else
         sessionStorage.setItem(pName,pQty);      
   }


if the product already exists in the session, the function will add the current required quantity to the existing session variable.

如果产品已经存在于会话，该函数将添加当前所需量到所述现有会话的变量。


结论

Conclusion

In this article, I explored the Web SQL database API and its usage by implementing a shopping cart application.

在这篇文章中，我探索了网络SQL数据库API及其用法通过实施购物车应用程序。

======================================================
Acknowledgments

The author would like to thank Raghavendran N, Principal, Education and Research Department (E&R) for his guidance and continuous support. I would like to thank Mr. Satheesha B N (AVP) and SVS (VP), E&R for motivating me to write this article. I would like to thank Mrs. Sangeetha for reviewing this article and providing valuable suggestions.

About the Author

Yuvarani Meiyappan works as a lead in the E&R division of Infosys Technologies Limited. She has over eight years of experience in design and development of Java and Java EE applications.
