<style>
	
/* Float four columns side by side */
.column-card {
  float: left;
  width: 25%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding in column-cards */
.row-card {margin: 0 -5px;}

/* Clear floats after the column-cards */
.row-card:after {
  content: "";
  display: table;
  clear: both;
}

/* Style the counter cards */
.card-custom {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* this adds the "card" effect */
  padding: 16px;
  text-align: left;
  background-color: #f1f1f1;
}

/* Responsive column-cards - one column-card layout (vertical) on small screens */
@media screen and (max-width: 600px) {
  .column-card {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

</style>





<button class="btn btn-primary tambah_data mt-4">Tambah Kuesioner</button>
<?php
if (!$list_kuesioner) {
?>
<div class="alert alert-danger">
 		Tidak ada kuesioner
</div>
<?php
} else {
	?>
	<div class="kuesioner-list-wrapper mt-4">
		<div class="row-card">

		<?php
		foreach ($list_kuesioner as $key => $value) {
			?>
			<div class="column-card">
				<div class="card-custom">
					<h3 style="font-size: 1.2rem; font-weight: bold;"><?php echo $value->judul_kuesioner ?></h3>
					<p>Lorem ipsum</p>
					<a href="<?php echo base_url().'kuesioner/export/'.$value->id_kuesioner ?>">Excel</a>
				</div>
			</div>
			<?php
		}
		?>
		</div>
	</div>
	<?php
}
?>