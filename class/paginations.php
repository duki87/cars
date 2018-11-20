<?php
  require_once('../db/db.php');
  require_once('../db/baseurl.php');
  $baseurl = baseurl();

  class Pagination {
    private $connect;
    private $url = 'http://localhost/cars/';

    function __construct() {
      $db = new Database();
      $this->connect = $db->connect();
    }

    public function request_pagination($records_per_page, $chunk_to_display, $sqlTable) {
      $chunk = json_decode($chunk_to_display);
      $per_page = json_decode($records_per_page);
      $table = json_decode($sqlTable);
      $query = "SELECT * FROM $table";
      $statement = $this->connect->prepare($query);
      $statement->execute();
      $queryResult = $statement->fetchAll();
      return $this->get_pagination_data($per_page, $chunk, $queryResult);
    }

    public function get_pagination_data($per_page = 5, $chunk, $result) {
      //var_dump($result);
      $records_per_page = $per_page;
      $paginations = '';
      $response = array();
      $data = array();
      $total_pages = ceil(count($result) / $records_per_page);
      $chunks = array_chunk($result, $records_per_page);
      //$chunk_to_display -= 1;
      $records = $chunks[$chunk];
      foreach ($records as $row) {
        $data[] = '<tr>
                    <td class="">'.$row['brand_name'].'</td>
                    <td class="">'.$row['brand_logo'].'</td>
                    <td class="">'.$row['brand_description'].'</td>
                  </tr>';
      }
      $chunkId = $chunk;
      $activeClass = '';
      if($chunkId == 0) {
        $activeClass = 'disabled';
      }
      $paginations .= '<li class="page-item '.$activeClass.'">
        <a class="page-link pagination-prev" href="#" data-chunkid="'.$chunkId.'" aria-label="Prethodno">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Prethodno</span>
        </a>
       </li>';
       if($total_pages < 3) {
         for($i=1; $i<=$total_pages; $i++) {
           $chunkId = $i-1;
           $paginations .= '<li class="page-item"><a class="page-link pagination-page active" data-chunkid="'.$chunkId.'" href="#">'.$i.'</a></li>';
         }
       } else {
         $chunkId = $chunk;
         if($chunkId == 0) {
           $paginations .= '<li class="page-item active"><a class="page-link pagination-page" data-chunkid="'.$chunkId.'" href="#">'.++$chunkId.'</a></li>
                            <li class="page-item"><a class="page-link pagination-page" data-chunkid="'.$chunkId.'" href="#">'.++$chunkId.'</a></li>
                            <li class="page-item"><a class="page-link pagination-page" data-chunkid="'.$chunkId.'" href="#">'.++$chunkId.'</a></li>';
         } else {
           $chunkIdActiveDisplay = $chunkId + 1;
           $chunkIdPrev = $chunkId - 1;
           $chunkIdPrevDisplay = $chunkId;
           $chunkIdNext = $chunkId + 1;
           $chunkIdNextDisplay = $chunkIdActiveDisplay + 1;

           $paginations .= '<li class="page-item"><a class="page-link pagination-page" data-chunkid="'.$chunkIdPrev.'" href="#">'.$chunkIdPrevDisplay.'</a></li>
                            <li class="page-item active"><a class="page-link pagination-page" data-chunkid="'.$chunkId.'" href="#">'.$chunkIdActiveDisplay.'</a></li>';

            if($chunkIdNextDisplay == $total_pages) {
              $paginations .= '<li class="page-item"><a class="page-link pagination-page" data-chunkid="'.$chunkIdNext.'" href="#">'.$chunkIdNextDisplay.'</a></li>';
            }
         }
       }
       $chunkId = $chunk;
       $activeClass = '';
       if($chunkId + 1 == $total_pages) {
         $activeClass = 'disabled';
       }
       $paginations .= '<li class="page-item '.$activeClass.'">
                         <a class="page-link pagination-next" href="#" data-chunkid="'.$chunkId.'" aria-label="Sledece">
                           <span aria-hidden="true">&raquo;</span>
                           <span class="sr-only">Sledece</span>
                         </a>
                        </li>';

      $response['pagination_data'] = $data;
      $response['total_pages'] = $total_pages;
      $response['chunks'] = $chunks;
      $response['paginations'] = $paginations;
      return json_encode($response);
    }

    public function pagination_for_adds($per_page = 5, $chunk, $result) {
      $records_per_page = $per_page;
      $paginations = '';
      $response = array();
      $data = array();
      $total_pages = ceil(count($result) / $records_per_page);
      $chunks = array_chunk($result, $records_per_page);
      $chunkId = $chunk;
      $records = $chunks[$chunk];
      $activeClass = '';
      if($chunkId == 0) {
        $activeClass = 'disabled';
      }
      $paginations .= '<li class="page-item '.$activeClass.'">
        <a class="page-link pagination-prev" href="#" data-chunkid="'.$chunkId.'" aria-label="Prethodno">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Prethodno</span>
        </a>
       </li>';
       if($total_pages < 3) {
         for($i=1; $i<=$total_pages; $i++) {
           $chunkId = $i-1;
           $paginations .= '<li class="page-item"><a class="page-link pagination-page active" data-chunkid="'.$chunkId.'" href="#">'.$i.'</a></li>';
         }
       } else {
         $chunkId = $chunk;
         if($chunkId == 0) {
           $paginations .= '<li class="page-item active"><a class="page-link pagination-page" data-chunkid="'.$chunkId.'" href="#">'.++$chunkId.'</a></li>
                            <li class="page-item"><a class="page-link pagination-page" data-chunkid="'.$chunkId.'" href="#">'.++$chunkId.'</a></li>
                            <li class="page-item"><a class="page-link pagination-page" data-chunkid="'.$chunkId.'" href="#">'.++$chunkId.'</a></li>';
         } else {
           $chunkIdActiveDisplay = $chunkId + 1;
           $chunkIdPrev = $chunkId - 1;
           $chunkIdPrevDisplay = $chunkId;
           $chunkIdNext = $chunkId + 1;
           $chunkIdNextDisplay = $chunkIdActiveDisplay + 1;

           $paginations .= '<li class="page-item"><a class="page-link pagination-page" data-chunkid="'.$chunkIdPrev.'" href="#">'.$chunkIdPrevDisplay.'</a></li>
                            <li class="page-item active"><a class="page-link pagination-page" data-chunkid="'.$chunkId.'" href="#">'.$chunkIdActiveDisplay.'</a></li>';

            if($chunkIdNextDisplay == $total_pages) {
              $paginations .= '<li class="page-item"><a class="page-link pagination-page" data-chunkid="'.$chunkIdNext.'" href="#">'.$chunkIdNextDisplay.'</a></li>';
            }
         }
       }
       $chunkId = $chunk;
       $activeClass = '';
       if($chunkId + 1 == $total_pages) {
         $activeClass = 'disabled';
       }
       $paginations .= '<li class="page-item '.$activeClass.'">
                         <a class="page-link pagination-next" href="#" data-chunkid="'.$chunkId.'" aria-label="Sledece">
                           <span aria-hidden="true">&raquo;</span>
                           <span class="sr-only">Sledece</span>
                         </a>
                        </li>';

      $response['data'] = $records;
      $response['total_pages'] = $total_pages;
      $response['chunks'] = $chunks;
      $response['paginations'] = $paginations;
      return json_encode($response);
    }
  }
