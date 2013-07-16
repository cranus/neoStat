<h1>Neo Statistiken</h1>
<img src="/plugins_packages/neo/neostat/assets/img/auto/zugriffe.png">
<? FOREACH($kwdata as $kw ) : ?>
	<div onclick="$('#neostatkw_<?= $kw['kw'] ?>').toggle('slow');"> Kalender Woche <?= $kw['kw'] ?>(Anzahl Zugriffe:  <?= $kw['zugriffe'] ?>)</div>
	<div style="float: left; width: 100%; display: none;" id="neostatkw_<?= $kw['kw'] ?>">
		<div style="float: left; width: 20%;">URL</div>
		<div style="float: left; width: 20%;">ID</div>
		<div style="float: left; width: 20%;">Titel der Seite</div>
		<div style="float: left; width: 20%;">Anzahl der Zugriffe</div>
		<div style="float: left; width: 20%;">1111</div>

	<? FOREACH($kw['data'] as $data ) : ?>
		<div style="float: left; width: 20%;"><?= $data["url"] ?></div>
		<div style="float: left; width: 20%;"><?= $data["id"] ?></div>
		<div style="float: left; width: 20%;"><?= $data["titel"] ?></div>
		<div style="float: left; width: 20%;"><?= $data["zugriffe"] ?></div>
		<div style="float: left; width: 20%;">1111</div>
	<? ENDFOREACH ?>
	</div>
<div style="width: 100%"></div>
<? ENDFOREACH ?>