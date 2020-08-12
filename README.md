# ShopPHPCLI


Shop is a small PHP CLI application running in memory.


### Installation


```sh
    execute the following command: php Shop
```


### Availible commands

This is a list of ALL commands. 

| Command | Description |
| ------ | ------ |
| ADD | Adding products to database : when you start the app you can add the products to the database. It requuires 4 parameters sku, product name, quantity, product price  |
| END |  Use this command to move to the shopping cart stage of the app, or to end the app , it receives no parameters |
| ADD| Adding products to shopping cart (this also checks if the products exist and if you are trying to buy more than available in the products table, be sure to add products first ), in this stage APP expects two parameters sku and quantity   |
| REMOVE | Removing the product from the shopping cart (you cannot remove the products that are not in the shopping cart), expects two parameters sku and quantity |
| CHECKOUT | To checkout use the following command (this will also reduce the quantity of products in the products table),  it receives no parameters |
