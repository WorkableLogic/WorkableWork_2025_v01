<?php
require_once('../../../../private/config/initialize.php');

if (is_post_request()) {
    $criteria_type = $_POST['criteria_type'] ?? '';

    if ($criteria_type === 'menu') {
        $criteria = [
            'fc_menu_cat_name' => $_POST['fc_menu_cat_name'] ?? 'All',
            'fc_menu_group_name' => $_POST['fc_menu_group_name'] ?? 'All',
            'fc_menu_type_name' => $_POST['fc_menu_type_name'] ?? 'All',
            'fc_menu_page' => $_POST['fc_menu_page'] ?? 'All',
            'fc_menu_name' => $_POST['fc_menu_name'] ?? ''
        ];
        $session->setFcMenuCriteria($criteria);
        redirect_to(url_for('/entity/jacolocal/foodcost/index.php?thing=menu_list'));

    } elseif ($criteria_type === 'menu_summary') {
        $criteria = [
            'fc_menu_cat_name' => $_POST['fc_menu_cat_name'] ?? 'All',
            'fc_menu_group_name' => $_POST['fc_menu_group_name'] ?? 'All',
            'fc_menu_type_name' => $_POST['fc_menu_type_name'] ?? 'All',
            'fc_menu_page' => $_POST['fc_menu_page'] ?? 'All',
            'fc_menu_name' => $_POST['fc_menu_name'] ?? ''
        ];
        $session->setFcMenuCriteria($criteria);
        redirect_to(url_for('/entity/jacolocal/foodcost/index.php?thing=menu_summary'));
        
    }elseif ($criteria_type === 'comm') {
        $criteria = [
            'fc_comm_name' => $_POST['fc_comm_name'] ?? '',
            'fc_comm_type' => $_POST['fc_comm_type'] ?? 'All',
            'fc_comm_supplier' => $_POST['fc_comm_supplier'] ?? ''
        ];
        $session->setFcCommCriteria($criteria);
        redirect_to(url_for('/entity/jacolocal/foodcost/index.php?thing=comm_list'));
    } elseif ($criteria_type === 'fc_map') {
        if (isset($_POST['action']) && $_POST['action'] === 'clear') {
            $session->clearFcMapCriteria();
        } else {
            $criteria = [
                'fc_menu_type' => $_POST['fc_menu_type'] ?? 'All',
                'fc_menu_name' => $_POST['fc_menu_name'] ?? '',
                'fc_comm_name' => $_POST['fc_comm_name'] ?? ''
            ];
            $session->setFcMapCriteria($criteria);
        }
        redirect_to(url_for('/entity/jacolocal/foodcost/index.php?thing=map_list'));
    }
} else {
    redirect_to(url_for('/entity/jacolocal/foodcost/index.php'));
}
