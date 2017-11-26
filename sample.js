<script>

var mysql = require('mysql');

var con = mysql.createConnection({
  host: "192.168.63.38",
  user: "root",
  password: "jfr3u9t",
  database: "abaka_db"
});

con.connect(function(err) {
  if (err) throw err;2
  con.query("SELECT t1.id, t3.category, t2.source, t1.item_url, t1.headline, t1.image, t1.description, t1.content, t1.fetch_date AS publishedAt FROM rss_content t1 
INNER JOIN rssingest t2 
INNER JOIN rss_category t3
ON t1.item_url = t2.item_url AND t1.category_id = t3.category_id WHERE t1.category_id = '1' AND t1.content != '' AND t1.fetch_date >= CURDATE() ORDER BY t1.image DESC", function (err, result) {
    if (err) throw err;
    console.log(result);
  });
});

</script>