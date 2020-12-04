### JSON Layout from getUserInfo.php

    success
    user
        id
        username
        email
        active
        admin
        created
        address
            street_address
            city
            province
            postal
        cart
            id
            status
            items[]
                product_id
                price
                discount
                quantity
        orders[]
            id
            total
            status
            items[]
                product_id
                price
                discount
                quantity

### JSON Layout for getProduct.php

    success
    product
        id
        name
        description
        price
        discount
        quantity
        status
        created
        updated
        catagory
            name
            description