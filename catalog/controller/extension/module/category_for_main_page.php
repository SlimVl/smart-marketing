<?php
class ControllerExtensionModuleCategoryForMainPage extends Controller {

    public function index() {

        $this->load->language('extension/module/category_for_main_page');
		
		$this->load->model( 'tool/image' );
        
        $data['categories'] = array();
        
        $results = $this->model_catalog_category->getCategories(0);
        
        foreach ($results as $result) {

            $category_info = $this->model_catalog_category->getCategory($result['category_id']);
            
            $subcategories = $this->model_catalog_category->getCategories($result['category_id']);
			
			shuffle( $subcategories );
            
            $subcategories_info = array();
            
            foreach ($subcategories as $subcategory) {
                $subcategories_info[] = array(
                    'name' => $subcategory['name'],
                    'href' => $this->url->link('product/category', 'path=' . $result['category_id'] . '_' . $subcategory['category_id'])
                );
            }
            
            $data['categories'][] = array(
                'name' => $category_info['name'],
                'subcategories' => $subcategories_info,
//                'thumb'  => $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height')),
                'thumb'  => ($category_info['image']) ? $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height')) : $this->model_tool_image->resize('no_image.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height')),
            );

        }
        
        if ($data['categories']) {
            return $this->load->view('extension/module/category_for_main_page', $data);
        }

    }

}