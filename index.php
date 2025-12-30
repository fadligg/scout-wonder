<?php 
include 'config.php'; 

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "ORDER BY id DESC";
switch ($sort) {
    case 'ovr_high':
        $orderBy = "ORDER BY (speed + dribbling + passing + shooting + defending + physical + stamina) DESC";
        break;
    case 'pot_high':
        $orderBy = "ORDER BY potensi DESC";
        break;
    default:
        $orderBy = "ORDER BY id DESC"; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Scout Wonder Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="icon-football.svg">
    <style> .font-oswald { font-family: 'Oswald', sans-serif; } </style>
</head>
<body class="bg-[#0f172a] text-white min-h-screen p-8 font-sans">

    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-bold font-oswald text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-500">SCOUT WONDER</h1>
                <p class="text-slate-400 mt-1 text-sm">Manage & Scout Your Wonderkid.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="" method="GET" class="flex items-center">
                    <select name="sort" onchange="this.form.submit()" class="text-4xl font-bold font-oswald bg-[#1e293b] text-white text-sm border border-slate-600 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none cursor-pointer hover:bg-slate-800 transition">
                        <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Latest</option>
                        <option value="ovr_high" <?= $sort == 'ovr_high' ? 'selected' : '' ?>>OVR</option>
                        <option value="pot_high" <?= $sort == 'pot_high' ? 'selected' : '' ?>>Potential</option>
                    </select>
                </form>

                <a href="create.php" class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white px-6 py-2 rounded-lg font-bold shadow-lg transform hover:-translate-y-0.5 transition flex items-center gap-2">
                    <span>+ New Wonderkid</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
            $query = "SELECT * FROM players $orderBy";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    $ovr = round(($row['speed'] + $row['dribbling'] + $row['passing'] + $row['shooting'] + $row['defending'] + $row['physical'] + $row['stamina']) / 7);

                    if ($ovr >= 85) {
                        $borderColor = 'border-yellow-500'; $shadowColor = 'hover:shadow-yellow-500/50'; $textColor = 'text-yellow-400';
                    } elseif ($ovr >= 75) {
                        $borderColor = 'border-cyan-500'; $shadowColor = 'hover:shadow-cyan-500/50'; $textColor = 'text-cyan-400';
                    } elseif ($ovr >= 65) {
                        $borderColor = 'border-green-500'; $shadowColor = 'hover:shadow-green-500/50'; $textColor = 'text-green-400';
                    } elseif ($ovr >= 55) {
                        $borderColor = 'border-slate-400'; $shadowColor = 'hover:shadow-slate-400/50'; $textColor = 'text-slate-300';
                    } else {
                        $borderColor = 'border-orange-700'; $shadowColor = 'hover:shadow-orange-700/50'; $textColor = 'text-orange-600';
                    }
            ?>
            
            <div class="group relative bg-[#1e293b] rounded-xl overflow-hidden border-2 <?= $borderColor ?> hover:shadow-[0_0_20px] <?= $shadowColor ?> transition transform hover:-translate-y-2 duration-300">
                
                <a href="detail.php?id=<?= $row['id'] ?>" class="block relative h-full">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
                    
                    <div class="relative p-4 flex flex-col items-center">
                        
                        <div class="absolute top-2 left-3">
                            <span class="text-3xl font-oswald font-bold <?= $textColor ?> drop-shadow-md block leading-none"><?= $ovr ?></span>
                            <span class="text-[10px] uppercase text-slate-400 font-bold tracking-widest">OVR</span>
                        </div>

                        <div class="absolute top-2 right-3 text-right">
                            <span class="text-3xl font-oswald font-bold text-gray-500 drop-shadow-md block leading-none"><?= $row['potensi'] ?></span>
                            <span class="text-[10px] uppercase text-gray-600 font-bold tracking-widest">POT</span>
                        </div>

                        <div class="relative mt-4 mb-2">
                             <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-full blur-lg opacity-0 group-hover:opacity-100 transition duration-500"></div>
                            <img src="uploads/<?= $row['foto'] ?>" class="h-40 w-40 object-cover drop-shadow-2xl z-10 relative group-hover:scale-110 transition duration-300">
                        </div>
                        
                        <div class="text-center w-full z-10">
                            <h3 class="text-xl font-bold font-oswald uppercase tracking-wide truncate text-gray-100"><?= $row['nama_pemain'] ?></h3>
                            <div class="text-xs font-bold text-slate-400 mb-2"><?= $row['posisi'] ?> | <?= $row['umur'] ?>YO</div>
                            <div class="h-0.5 w-full bg-slate-700 mb-3"></div>
                            
                            <div class="grid grid-cols-3 gap-2 text-xs text-slate-300 font-oswald">
                                <?php if($row['posisi'] == 'Goalkeeper') { ?>
                                    <div><span class="font-bold text-white"><?= $row['dribbling'] ?></span> DIV</div>
                                    <div><span class="font-bold text-white"><?= $row['passing'] ?></span> HAN</div>
                                    <div><span class="font-bold text-white"><?= $row['defending'] ?></span> REF</div>
                                <?php } else { ?>
                                    <div><span class="font-bold text-white"><?= $row['speed'] ?></span> PAC</div>
                                    <div><span class="font-bold text-white"><?= $row['dribbling'] ?></span> DRI</div>
                                    <div><span class="font-bold text-white"><?= $row['shooting'] ?></span> SHO</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus pemain ini?')" 
                   class="absolute bottom-0 right-0 bg-red-600/90 hover:bg-red-600 text-white p-2 rounded-tl-xl z-20 opacity-0 group-hover:opacity-100 transition backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </a>
            </div>
            
            <?php 
                }
            } else { 
            ?>
                <div class="col-span-full text-center py-20">
                    <div class="text-6xl mb-4">⚽</div>
                    <h3 class="text-2xl font-bold text-slate-500">No Wonderkids Scouted Yet</h3>
                    <p class="text-slate-600 mt-2">Start by adding new talent to your database.</p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>