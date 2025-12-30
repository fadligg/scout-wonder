<?php
include 'config.php';

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
    $foto   = $_FILES['foto']['name'];
    $tmp    = $_FILES['foto']['tmp_name'];
    $fotobaru = date('dmYHis').$foto;
    $path     = "uploads/".$fotobaru;

    if(move_uploaded_file($tmp, $path)){
        $query = "INSERT INTO players 
                  (nama_pemain, posisi, klub, umur, foot, potensi, foto, 
                   speed, dribbling, passing, shooting, defending, physical, stamina) 
                  VALUES 
                  ('$nama', '$posisi', '$klub', '$umur', '$foot', '$potensi', '$fotobaru', 
                   '$speed', '$dribbling', '$passing', '$shooting', '$defending', '$physical', '$stamina')";
        
        $sql = mysqli_query($conn, $query);

        if ($sql) {
            header("Location: index.php");
        } else {
            echo "Failed to execute SQL: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Scout Wonder - Add Wonderkid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="icon-football.svg">
    <style>
        .font-oswald { font-family: 'Oswald', sans-serif; }
        input[type="radio"]:checked + label {
            background-color: #0891b2;
            border-color: #22d3ee;
            color: white;
        }
    </style>
</head>
<body class="bg-[#0f172a] text-white py-10 font-sans">

    <div class="max-w-3xl mx-auto bg-[#1e293b] rounded-2xl shadow-2xl p-8 border border-slate-700">
        <h2 class="text-3xl font-bold font-oswald text-cyan-400 mb-2">Create New Player Card</h2>
        <p class="text-slate-400 text-sm mb-6 border-b border-slate-700 pb-4">Define attributes, preferred foot, and potential.</p>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
            
            <div>
                <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                    <span class="bg-blue-600 w-6 h-6 rounded flex items-center justify-center text-xs">1</span> Wonderkid Info
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label class="text-slate-400 text-sm block mb-1">Name</label>
                        <input type="text" name="nama_pemain" class="w-full bg-slate-900 border border-slate-600 rounded p-2 focus:border-cyan-500 outline-none text-white" required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="text-slate-400 text-sm block mb-1">Preferred Foot</label>
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <input type="radio" name="foot" id="right" value="Right" class="hidden" checked>
                                <label for="right" class="block w-full text-center p-2 border border-slate-600 rounded cursor-pointer bg-slate-900 hover:bg-slate-800 transition text-sm">Right</label>
                            </div>
                            <div class="flex-1">
                                <input type="radio" name="foot" id="left" value="Left" class="hidden">
                                <label for="left" class="block w-full text-center p-2 border border-slate-600 rounded cursor-pointer bg-slate-900 hover:bg-slate-800 transition text-sm">Left</label>
                            </div>
                            <div class="flex-1">
                                <input type="radio" name="foot" id="both" value="Both" class="hidden">
                                <label for="both" class="block w-full text-center p-2 border border-slate-600 rounded cursor-pointer bg-slate-900 hover:bg-slate-800 transition text-sm">Both</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-slate-400 text-sm block mb-1">Position</label>
                        <select name="posisi" id="posisiSelect" onchange="updateLabels()" class="w-full bg-slate-900 border border-slate-600 rounded p-2 focus:border-cyan-500 outline-none text-white">
                            <option value="Forward">Forward</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Defender">Defender</option>
                            <option value="Goalkeeper">Goalkeeper</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-slate-400 text-sm block mb-1">Club</label>
                        <input type="text" name="klub" class="w-full bg-slate-900 border border-slate-600 rounded p-2 focus:border-cyan-500 outline-none text-white" required>
                    </div>

                    <div>
                        <label class="text-slate-400 text-sm block mb-1">Age</label>
                        <input type="number" name="umur" class="w-full bg-slate-900 border border-slate-600 rounded p-2 focus:border-cyan-500 outline-none text-white" required>
                    </div>
                    <div>
                        <label class="text-amber-400 text-sm block mb-1 font-bold">Potential (Max)</label>
                        <input type="number" name="potensi" min="1" max="99" class="w-full bg-slate-900 border border-amber-500/50 rounded p-2 focus:border-amber-500 outline-none text-white" placeholder="e.g. 94" required>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                    <span class="bg-cyan-600 w-6 h-6 rounded flex items-center justify-center text-xs">2</span> 
                    <span id="statsTitle">Player Stats</span>
                </h3>
                <div class="grid grid-cols-2 gap-x-8 gap-y-4 bg-slate-800/50 p-6 rounded-xl border border-slate-700">
                    
                    <div>
                        <label class="flex justify-between text-xs uppercase font-bold text-slate-400 mb-1">
                            Speed <span id="val_speed" class="text-cyan-400 text-sm">50</span>
                        </label>
                        <input type="range" name="speed" min="0" max="99" value="50" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-500" oninput="document.getElementById('val_speed').innerText = this.value">
                    </div>

                    <div>
                        <label class="flex justify-between text-xs uppercase font-bold text-slate-400 mb-1">
                            <span id="label_dribbling">Dribbling</span> <span id="val_dribbling" class="text-cyan-400 text-sm">50</span>
                        </label>
                        <input type="range" name="dribbling" min="0" max="99" value="50" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-500" oninput="document.getElementById('val_dribbling').innerText = this.value">
                    </div>

                    <div>
                        <label class="flex justify-between text-xs uppercase font-bold text-slate-400 mb-1">
                            <span id="label_passing">Passing</span> <span id="val_passing" class="text-cyan-400 text-sm">50</span>
                        </label>
                        <input type="range" name="passing" min="0" max="99" value="50" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-500" oninput="document.getElementById('val_passing').innerText = this.value">
                    </div>

                    <div>
                        <label class="flex justify-between text-xs uppercase font-bold text-slate-400 mb-1">
                            <span id="label_shooting">Shooting</span> <span id="val_shooting" class="text-cyan-400 text-sm">50</span>
                        </label>
                        <input type="range" name="shooting" min="0" max="99" value="50" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-500" oninput="document.getElementById('val_shooting').innerText = this.value">
                    </div>

                    <div>
                        <label class="flex justify-between text-xs uppercase font-bold text-slate-400 mb-1">
                            <span id="label_defending">Defending</span> <span id="val_defending" class="text-cyan-400 text-sm">50</span>
                        </label>
                        <input type="range" name="defending" min="0" max="99" value="50" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-500" oninput="document.getElementById('val_defending').innerText = this.value">
                    </div>

                    <div>
                        <label class="flex justify-between text-xs uppercase font-bold text-slate-400 mb-1">
                            <span id="label_physical">Physical</span> <span id="val_physical" class="text-cyan-400 text-sm">50</span>
                        </label>
                        <input type="range" name="physical" min="0" max="99" value="50" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-500" oninput="document.getElementById('val_physical').innerText = this.value">
                    </div>

                    <div>
                        <label class="flex justify-between text-xs uppercase font-bold text-slate-400 mb-1">
                            <span id="label_stamina">Stamina</span> <span id="val_stamina" class="text-cyan-400 text-sm">50</span>
                        </label>
                        <input type="range" name="stamina" min="0" max="99" value="50" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-500" oninput="document.getElementById('val_stamina').innerText = this.value">
                    </div>

                </div>
            </div>

            <div>
                <label class="text-slate-400 text-sm block mb-1">Upload Wonderkid Photo</label>
                <input type="file" name="foto" class="w-full text-slate-400 file:bg-slate-700 file:text-white file:border-0 file:py-2 file:px-4 file:rounded-full hover:file:bg-slate-600 cursor-pointer" required>
            </div>

            <div class="pt-4 flex gap-4">
                <a href="index.php" class="w-1/3 text-center py-3 rounded-lg border border-slate-600 text-slate-400 hover:text-white hover:bg-slate-700 transition">Cancel</a>
                <button type="submit" class="w-2/3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold py-3 rounded-lg shadow-lg transform hover:-translate-y-1 transition duration-200">
                    ADD WONDERKID
                </button>
            </div>
        </form>
    </div>

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
                document.getElementById(id).innerText = isGK ? texts[1] : texts[0];
            }
            document.getElementById('statsTitle').innerText = isGK ? 'Goalkeeper Attributes' : 'Player Attributes';
        }
    </script>
</body>
</html>