1.
SELECT orders.id as order_id, count(product_id) as count_products
FROM orders  JOIN orders_products ON orders.id = orders_products.order_id
GROUP BY order_id

2.
SELECT order_id, count(orders_products.product_id) as count_items
FROM orders JOIN orders_products ON orders.id = orders_products.order_id
GROUP BY orders.id
HAVING count(orders_products.product_id) > 10

3.
SELECT orders.id as order_id, count(product_id) as count_products
FROM orders JOIN orders_products ON orders.id = orders_products.order_id
GROUP BY order_id
ORDER BY count_products DESC
LIMIT 2
