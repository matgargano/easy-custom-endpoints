example:

$x = new Custom_endpoint('test');
$x->set_template(dirname(__FILE__) . '/views/view.php');
$x->set_query_variables(array('post_type' => array('post', 'page')));

