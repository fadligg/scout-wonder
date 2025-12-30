<?php
include 'config.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM players WHERE id='$id'");
$row   = mysqli_fetch_assoc($query);

if (!$row) {
    echo "Wonderkid Could Not Be Found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama   = $_POST['nama_pemain'];
    $posisi = $_POST['posisi'];
    $klub   = $_POST['klub'];
    $umur   = $_POST['umur'];
    $foot   = $_POST['foot']; 
    $potensi = $_POST['potensi'];
    $speed     = $_POST['speed'];
    $dribbling = $_POST['dribbling'];
    $passing   = $_POST['passing'];
    $shooting  = $_POST['shooting'];
    $defending = $_POST['defending'];
    $physical  = $_POST['physical'];
    $stamina   = $_POST['stamina'];

    $foto_query = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto     = $_FILES['foto']['name'];
        $tmp      = $_FILES['foto']['tmp_name'];
        $fotobaru = date('dmYHis').$foto;
        $path     = "uploads/".$fotobaru;
        
        if(move_uploaded_file($tmp, $path)){
            $foto_query = ", foto='$fotobaru'";
        }
    }

    $update = "UPDATE players SET 
               nama_pemain='$nama', posisi='$posisi', klub='$klub', umur='$umur', 
               foot='$foot', potensi='$potensi',
               speed='$speed', dribbling='$dribbling', passing='$passing', 
               shooting='$shooting', defending='$defending', physical='$physical', stamina='$stamina'
               $foto_query
               WHERE id='$id'";

    if (mysqli_query($conn, $update)) {
        header("Location: detail.php?id=$id"); 
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Scout Wonder - Edit Wonderkid: <?= $row['nama_pemain'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="icon-football.svg">
    <style>
        .font-oswald { font-family: 'Oswald', sans-serif; }
        input[type="radio"]:checked + label {
            background-color: #d97706; border-color: #fbbf24; color: white;
        }
    </style>
</head>
<body class="bg-[#0f172a] text-white py-10 font-sans">
    <div class="max-w-3xl mx-auto bg-[#1e293b] rounded-2xl shadow-2xl p-8 border border-slate-700 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-amber-500 to-orange-600"></div>
        <div class="flex justify-between items-center mb-6 border-b border-slate-700 pb-4">
            <div>
                <h2 class="text-3xl font-bold font-oswald text-amber-500">Edit Attributes</h2>
                <p class="text-slate-400 text-sm">Update statistics and player details.</p>
            </div>
            <img src="uploads/<?= $row['foto'] ?>" class="w-12 h-12 rounded-full border-2 border-slate-600 object-cover">
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
            <div>
                <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                    <span class="bg-amber-600 w-6 h-6 rounded flex items-center justify-center text-xs">1</span> Wonderkid Info
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label class="text-slate-400 text-sm block mb-1">Name</label>
                        <input type="text" name="nama_pemain" value="<?= $row['nama_pemain'] ?>" class="w-full bg-slate-900 border border-slate-600 rounded p-2 focus:border-amber-500 outline-none text-white transition">
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="text-slate-400 text-sm block mb-1">Preferred Foot</label>
                        <div class="flex gap-2">
                            <div class="flex-1"><input type="radio" name="foot" id="right" value="Right" class="hidden" <?= $row['foot']=='Right' ? 'checked' : '' ?>><label for="right" class="block w-full text-center p-2 border border-slate-600 rounded cursor-pointer bg-slate-900 hover:bg-slate-800 transition text-sm">Right</label></div>
                            <div class="flex-1"><input type="radio" name="foot" id="left" value="Left" class="hidden" <?= $row['foot']=='Left' ? 'checked' : '' ?>><label for="left" class="block w-full text-center p-2 border border-slate-600 rounded cursor-pointer bg-slate-900 hover:bg-slate-800 transition text-sm">Left</label></div>
                            <div class="flex-1"><input type="radio" name="foot" id="both" value="Both" class="hidden" <?= $row['foot']=='Both' ? 'checked' : '' ?>><label for="both" class="block w-full text-center p-2 border border-slate-600 rounded cursor-pointer bg-slate-900 hover:bg-slate-800 transition text-sm">Both</label></div>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-400 text-sm block mb-1">Position</label>
                        <select name="posisi" class="w-full bg-slate-900 border border-slate-600 rounded p-2 focus:border-amber-500 outline-none text-white">
                            <option <?= $row['posisi']=='Forward'?'selected':'' ?>>Forward</option>
                            <option <?= $row['posisi']=='Midfielder'?'selected':'' ?>>Midfielder</option>
                            <option <?= $row['posisi']=='Defender'?'selected':'' ?>>Defender</option>
                            <option <?= $row['posisi']=='Goalkeeper'?'selected':'' ?>>Goalkeeper</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-slate-400 text-sm block mb-1">Club</label>
                        <input type="text" name="klub" value="<?= $row['klub'] ?>" class="w-full bg-slate-900 border border-slate-600 rounded p-2 focus:border-amber-500 outline-none text-white">
                    </div>
                    <div>
                        <label class="text-slate-400 text-sm block mb-1">Age</label>
                        <input type="number" name="umur" value="<?= $row['umur'] ?>" class="w-full bg-slate-900 border border-slate-600 rounded p-2 focus:border-amber-500 outline-none text-white">
                    </div>
                    <div>
                        <label class="text-amber-400 text-sm block mb-1 font-bold">Potential (Max)</label>
                        <input type="number" name="potensi" value="<?= $row['potensi'] ?>" min="1" max="99" class="w-full bg-slate-900 border border-amber-500/50 rounded p-2 focus:border-amber-500 outline-none text-white">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                    <span class="bg-amber-600 w-6 h-6 rounded flex items-center justify-center text-xs">2</span> Update Stats
                </h3>
                <div class="grid grid-cols-2 gap-x-8 gap-y-4 bg-slate-800/50 p-6 rounded-xl border border-slate-700">
                    <?php 
                    $stats = ['Speed', 'Dribbling', 'Passing', 'Shooting', 'Defending', 'Physical', 'Stamina'];
                    foreach($stats as $s): 
                        $name = strtolower($s);
                        $val  = $row[$name]; 
                    ?>
                    <div>
                        <label class="flex justify-between text-xs uppercase font-bold text-slate-400 mb-1">
                            <?= $s ?> <span id="val_<?= $name ?>" class="text-amber-400 text-sm"><?= $val ?></span>
                        </label>
                        <input type="range" name="<?= $name ?>" min="0" max="99" value="<?= $val ?>" 
                               class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-amber-500"
                               oninput="document.getElementById('val_<?= $name ?>').innerText = this.value">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <label class="text-slate-400 text-sm block mb-1">Change Photo (Optional)</label>
                <input type="file" name="foto" class="w-full text-slate-400 file:bg-slate-700 file:text-white file:border-0 file:py-2 file:px-4 file:rounded-full hover:file:bg-slate-600 cursor-pointer">
                <p class="text-xs text-slate-500 mt-2">*Leave blank if you don't want to change the photo.</p>
            </div>

            <div class="pt-4 flex gap-4">
                <a href="detail.php?id=<?= $id ?>" class="w-1/3 text-center py-3 rounded-lg border border-slate-600 text-slate-400 hover:text-white hover:bg-slate-700 transition">Cancel</a>
                <button type="submit" class="w-2/3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white font-bold py-3 rounded-lg shadow-lg transform hover:-translate-y-1 transition duration-200">
                    UPDATE DATA
                </button>
            </div>
        </form>
    </div>
</body>
<script>
    function updateLabels() {
        const role = document.getElementById('posisiSelect').value;
        const isGK = role === 'Goalkeeper';
        
        const mapping = {
            'label_dribbling': ['Dribbling', 'Diving'],
            'label_passing':   ['Passing',   'Handling'],
            'label_shooting':  ['Shooting',  'Kicking'],
            'label_defending': ['Defending', 'Reflexes'],
            'label_physical':  ['Physical',  'Positioning'],
            'label_stamina':   ['Stamina',   'Reactions']
        };

        for (const [id, texts] of Object.entries(mapping)) {
            if(document.getElementById(id)) {
                document.getElementById(id).innerText = isGK ? texts[1] : texts[0];
            }
        }
    }
    window.onload = updateLabels;
</script>
</html>