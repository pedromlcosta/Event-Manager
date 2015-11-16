 <?php foreach ($result as $row) { ?>
      <div class="news-item">
        <h3><?php  echo $row['title']; ?></h3>
        <img src="http://ipsumimage.appspot.com/300x200,ff7700" alt="300x200">
        <p class="introduction"> 
        <?php echo $row['introduction']; ?>
        </p>
        <p> <?php echo $row['fulltext']; ?> </p>
        <ul>
          <li><a href="news_item.php?id=<?=$row['id']?>">See more</a></li>
        </ul>
      </div>
      <?php } ?>