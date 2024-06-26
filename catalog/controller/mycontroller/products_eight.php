<?php
class ControllerMycontrollerproductseight extends Controller {
    public function index() {
		//check if its an ajax request
        if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && $this->request->server['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            $this->load->model('catalog/product');
            $this->load->model('tool/image');

            $rating = isset($this->request->get['rating']) ? $this->request->get['rating'] : 0;  //get rating or set it to 0

            $json = array();
            $results = $this->model_catalog_product->getProductsWithRatings($rating);//ask for products with rating 

            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], 40, 40);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', 40, 40);
                }

                $json[] = array(
                    'product_id' => $result['product_id'],
                    'name'       => $result['name'],
                    'price'      => $this->currency->format($result['price'], $this->session->data['currency']),
                    'avg_rating' => $result['avg_rating'],
                    'image'      => $image,
                    'url'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
                );
            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        } else {
            $data['header'] = $this->load->controller('common/header');
            $data['footer'] = $this->load->controller('common/footer');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');

            $this->response->setOutput($this->load->view('mycontroller/products_eight', $data));
        }
    }
}

