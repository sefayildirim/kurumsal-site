<?php include 'header.php';

$etkinliklersor=$db->prepare("select * from etkinlikler order by etkinlikler_id desc ");
$etkinliklersor->execute();
$toplam_icerik=$etkinliklersor->rowCount();

$sayfada = 10;
$toplam_sayfa = ceil($toplam_icerik / $sayfada);

// eğer sayfa girilmemişse 1 varsayalım.
$sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
if($sayfa < 1) $sayfa = 1; 

// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

// kaçıncı içerikten başlanacağını ifade edecek limit değeri.
$limit = ($sayfa - 1) * $sayfada;

$sorgu=$db->prepare("select * from etkinlikler order by etkinlikler_id desc LIMIT " . $limit . ", " . $sayfada."");
$sorgu->execute();


?>

 <script language="javascript"> function confirmDel() { var agree=confirm("Bu etkinliği silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!"); if (agree) { return true ; } else { return false ;} } </script>

<div class="table-responsive">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<br>
				<br>
				<a href="etkinliklerekle.php">
					<button class="btn btn-primary"><i class="fas fa-plus"></i> Yeni Ekle</button>
				</a>
				<br>
				<br>


				<table class="table">
					<thead style="background-color: #03363D; color: white;">
						<tr>
							<th>No</th>
							<th>Resim</th>
							<th>Tarih</th>
							<th>Başlık</th>
							<th>Düzenle</th>
							<th>Sil</th>
						</tr>
					</thead>
					<tbody>
						<?php 



						while($etkinliklercek=$sorgu->fetch(PDO::FETCH_ASSOC)) {
							?>
							<tr>
								<td><?php echo $etkinliklercek['etkinlikler_id']; ?></td>
								<td><img width="120" height="100" src="../<?php echo $etkinliklercek['etkinlikler_yol']; ?>"></td>
								<td><?php echo $etkinliklercek['etkinlikler_tarih']; ?></td>
								<td><?php echo $etkinliklercek['etkinlikler_baslik']; ?></td>

								
								<td><a href="etkinliklerduzenle.php?etkinlikler_id=<?php echo $etkinliklercek['etkinlikler_id']; ?>"><button  class="btn btn-primary btn-xs"><i class="fas fa-pencil-alt"></i> Düzenle</button></a></td>

								<td><a href="islem.php?etkinliklersil=ok&etkinlikler_id=<?php echo $etkinliklercek['etkinlikler_id']; ?>" onclick="return confirmDel();"><button style="width:80px;" class="btn btn-danger btn-xs"><i class="fa fa-trash" aria-hidden="true"></i> Sil</button></a></td>
							</tr>
						<?php } ?>    


					</tbody>
				</table>

			</div>
			<br>
			<br>
			<br>
			<nav aria-label="Page navigation example">
				<ul class="pagination">

					<?php 
					for($s = 1; $s <= $toplam_sayfa; $s++)
					{
           if($sayfa == $s) { // eğer bulunduğumuz sayfa ise link yapma.
                 //echo $s . ' '; 
           	echo '<li class="page-item active"><a class="page-link" href="javascript:;">' . $s . '</a></li> ';
           } else {
           	echo '<li class="page-item"><a class="page-link" href="?sayfa=' . $s . '">' . $s . '   </a></li> ';
           }
       }  
       ?> 

   </ul>

</nav>
</div>
</div>
<br>
<br>
<br>
<br>
<br>
</div>
<script type="text/javascript" src="custom.js"></script>



<?php include 'footer.php'; ?>

