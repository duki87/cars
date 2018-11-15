<?php
  // require_once('db/db.php');
  require_once('class/paginator.php');
  require_once('db/db.php');
  include('parts/header.php');

  $limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
  $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
  $links = (isset( $_GET['links'])) ? $_GET['links'] : 3;
  $query = "SELECT brand_name, brand_logo, brand_description FROM brands WHERE brand_status = 1";
  $Paginator = new Paginator($query);
  $results = $Paginator->getData($page, $limit);

?>
    <div class="col-md-10 col-md-offset-1">
    <h1>PHP Pagination</h1>
    <table class="table table-striped table-condensed table-bordered table-rounded">
      <thead>
        <tr>
          <th width="20%">brand_name</th>
          <th width="20%">brand_logo</th>
          <th width="25%">brand_description</th>
        </tr>
      </thead>
      <tbody>
        <?php for($i = 0; $i < count($results->data); $i++) : ?>
          <tr>
            <td><?php echo $results->data[$i]['brand_name']; ?></td>
            <td><?php echo $results->data[$i]['brand_logo']; ?></td>
            <td><?php echo $results->data[$i]['brand_description']; ?></td>
          </tr>
        <?php endfor; ?>
      </tbody>
    </table>
    <?php echo $Paginator->createLinks($links, 'pagination pagination-sm'); ?>
    </div>
  </div>
</body>
</html>
