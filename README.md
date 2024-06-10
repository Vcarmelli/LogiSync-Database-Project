# 📦LogiSync: A Supply Chain Management System
**LogiSync** is a website designed to manage suppliers, products, and purchase orders efficiently. This system provides different access levels for Admins, Managers, and Guests, ensuring a streamlined and secure workflow. 

This project is built using PHP for the backend and MySQL for the database.

## Features

- **Authentication**
  - **Signup:** Create a new account.
  - **Login:** Access your account based on your role (Admin, Manager, Guest).
  
- **User Roles**
  - **Admin:** Full CRUD operations on Suppliers, Products, and Purchase Orders
  - **Manager:** Create and Read operations on Suppliers, Products, and Purchase Orders
  - **Guest:** View the Dashboard

## Database Schema

<table style="border-collapse: collapse;">
<tr>
  <th>Supplier </th>
  <th>Product</th> 
  <th>Purchase Order</th>
</tr>
<tr>
  <td>
      
  | Column Name   | Data Type |
  | ------------- | --------- |
  | SupplierID    | INT       |
  | SupplierName  | VARCHAR   |
  | ContactPerson | VARCHAR   |
  | ContactNumber | VARCHAR   |

  </td>
  <td>

  | Column Name   | Data Type |
  | ------------- | --------- |
  | ProductID     | VARCHAR   |
  | ProductName   | VARCHAR   |
  | SupplierID    | INT       |
  | Price         | DECIMAL   |
  | Quantity      | INT       |

  </td>
  <td>

  | Column Name   | Data Type |
  | ------------- | --------- |
  | OrderID       | VARCHAR   |
  | SupplierID    | INT       |
  | OrderDate     | DATE      |
  | DeliveryDate  | DATE      |

  </td>
  
  </tr> 
</table>



## Screenshots

### Home Page
![homepage](https://github.com/Vcarmelli/database-final-project/assets/93195292/65eb9b30-194f-42e8-8eef-5b72b9b4f62c)


### Login/Signup Page
<p align="center">
    <img width="49%" src="https://github.com/Vcarmelli/database-final-project/assets/93195292/661c3ca0-8e10-4fce-aa93-a3365d487a43" alt="Login"/>
    &nbsp;
    <img width="49%" src="https://github.com/Vcarmelli/database-final-project/assets/93195292/5dc375ab-7fdd-45c2-a479-44fbbdc39534" alt="Signup"/>
</p>

### Dashboard
![dashboard](https://github.com/Vcarmelli/database-final-project/assets/93195292/7ae66284-6f35-4a6f-8470-8e14e9a12575)

### Suppliers Management

#### Admin View
![suppliers_admin](https://github.com/Vcarmelli/database-final-project/assets/93195292/540a2898-e39e-4e9f-9ff2-2fbe7db19b81)
#### Manager View
![suppliers_manager](https://github.com/Vcarmelli/database-final-project/assets/93195292/3d7cc6f6-1a01-43a0-accf-5b521268bf62)

### Products Management

#### Admin View
![products_admin](https://github.com/Vcarmelli/database-final-project/assets/93195292/cdafad81-2008-410f-b1a8-e40c64b58a60)
#### Manager View
![products_manager](https://github.com/Vcarmelli/database-final-project/assets/93195292/7b5f07a8-7ff8-40d2-96e6-0bc5f314d874)

### Purchase Orders Management

#### Admin View
![orders_admin](https://github.com/Vcarmelli/database-final-project/assets/93195292/999a2f22-b1be-4288-91ce-c83d54885b21)
#### Manager View
![orders_manager](https://github.com/Vcarmelli/database-final-project/assets/93195292/30dd6834-6b52-441a-aa10-794deb281768)

### Guest View
![guest](https://github.com/Vcarmelli/database-final-project/assets/93195292/6158f509-0efa-45b0-ae20-9fc76b1b65ab)


---


<div align="center">
  <h6>Database Project by Vashti Karmelli V. Camu</h6>
</div> 

