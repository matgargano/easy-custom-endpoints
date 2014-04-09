example:

$x = new Custom_Endpoint('test');
$x->set_template(dirname(__FILE__) . '/views/view.php');
$x->set_query_variables(array('post_type' => array('post', 'page')));

