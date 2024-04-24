<?php
class ModelExtensionModulemymodule extends Model {
    public function install() {
        // SQL to create the table
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `product_avg_rating` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `product_id` int(11) NOT NULL,
                `avg_rating` float NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `product_id` (`product_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        // Fetch existing product IDs
        $query = $this->db->query("SELECT product_id FROM oc_product");

        // Loop through each product and insert a random rating
        foreach ($query->rows as $result) {
            $randomRating = mt_rand(10, 50) / 10; // Generates random ratings between 1.0 and 5.0
            $this->db->query("INSERT INTO `product_avg_rating` (`product_id`, `avg_rating`) VALUES ('" . (int)$result['product_id'] . "', '" . $randomRating . "')");
        }
    }

    public function uninstall() {
        // Drop the table
        $this->db->query("DROP TABLE IF EXISTS `product_avg_rating`;");
    }
}
