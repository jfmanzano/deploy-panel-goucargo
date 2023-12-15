INSERT INTO
    `templates` (
        `id`,
        `name`,
        `customer_fields`,
        `own_fields`,
        `created_at`,
        `updated_at`
    )
VALUES
    (
        1,
        'DEFAULT_TEMPLATE',
        'Order Code;Order Comments;Sent To Name;Send To Address;Send To Zip Code;Send To Village/Neighborhood;Send To City;Send To Phone Number;Send To Person;SKU;Quantity',
        'order_code;order_comments;send_to_name;send_to_address;send_to_zipcode;send_to_village_neighborhood;send_to_city;send_to_phone_number;send_to_person;sku;quantity',
        '2023-11-08 13:16:03',
        '2023-11-08 13:16:03'
    ),
    (
        2,
        'MIRAKL_TEMPLATE',
        'Número de pedido;Detalles;Dirección de entrega: apellido;Dirección de entrega: calle 1;Dirección de entrega: código postal;Dirección de entrega: provincia;Dirección de entrega: ciudad;Dirección de entrega: teléfono;Dirección de facturación: apellido;SKU de oferta;Cantidad',
        'order_code;order_comments;send_to_name;send_to_address;send_to_zipcode;send_to_village_neighborhood;send_to_city;send_to_phone_number;send_to_person;sku;quantity',
        '2023-11-08 13:06:39',
        '2023-11-08 13:06:39'
    );
