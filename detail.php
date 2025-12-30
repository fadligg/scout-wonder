<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("Error: Wonderkid's ID could not be found in the URL. You may go back to <a href='index.php'>Dashboard</a>");
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM players WHERE id='$id'");
$p = mysqli_fetch_assoc($query);

if (!$p) {
    die("Error: Wonderkid with $id could not be found. You may go back to <a href='index.php'>Dashboard</a>");
}

$overall = round(($p['speed'] + $p['dribbling'] + $p['passing'] + $p['shooting'] + $p['defending'] + $p['physical'] + $p['stamina']) / 7);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Scout Wonder - Profile: <?= $p['nama_pemain'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="icon-football.svg">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, .stat-font { font-family: 'Oswald', sans-serif; }
    </style>
</head>
<body class="bg-[#0f172a] text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-5xl w-full">
        <a href="index.php" class="inline-flex items-center text-gray-400 hover:text-cyan-400 mb-6 transition">
            &larr; Back to Dashboard
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 bg-[#1e293b] rounded-3xl p-8 shadow-2xl border border-slate-700 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-500/10 blur-[80px] rounded-full pointer-events-none"></div>

            <div class="lg:col-span-1 flex flex-col items-center lg:items-start z-10">
                <div class="relative mb-6 group w-full flex justify-center lg:justify-start">
                    <div class="absolute inset-0 bg-gradient-to-t from-cyan-500 to-purple-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition w-64 h-64 mx-auto lg:mx-0"></div>
                    
                    <img src="uploads/<?= $p['foto'] ?>" class="relative w-64 h-64 object-cover rounded-2xl border-2 border-slate-600 shadow-lg mx-auto lg:mx-0" alt="<?= $p['nama_pemain'] ?>">
                    
                    <div class="absolute -top-4 right-16 lg:right-16 w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex flex-col items-center justify-center border-4 border-[#1e293b] shadow-xl z-10">
                        <span class="text-xl font-bold stat-font text-white leading-none"><?= $overall ?></span>
                        <span class="text-[8px] font-bold text-blue-100">OVR</span>
                    </div>

                    <div class="absolute -top-4 -right-4 lg:-right-4 w-16 h-16 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-full flex flex-col items-center justify-center border-4 border-[#1e293b] shadow-xl z-20">
                        <span class="text-xl font-bold stat-font text-white leading-none"><?= $p['potensi'] ?></span>
                        <span class="text-[8px] font-bold text-yellow-100">POT</span>
                    </div>
                </div>

                <h1 class="text-4xl font-bold uppercase tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400 mb-1 text-center lg:text-left">
                    <?= $p['nama_pemain'] ?>
                </h1>
                <p class="text-cyan-400 font-semibold tracking-wider text-lg mb-6 uppercase"><?= $p['posisi'] ?> | <?= $p['klub'] ?></p>

                <div class="w-full space-y-3">
                    <div class="flex justify-between border-b border-slate-700 pb-2">
                        <span class="text-slate-400 text-sm">Age</span>
                        <span class="font-bold"><?= $p['umur'] ?> Years Old</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-700 pb-2">
                        <span class="text-slate-400 text-sm">Preferred Foot</span>
                        <span class="font-bold text-cyan-300"><?= $p['foot'] ?></span>
                    </div>
                </div>
                
                <div class="mt-8 flex gap-3 w-full">
                    <a href="edit.php?id=<?= $p['id'] ?>" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white text-center py-3 rounded-lg font-bold transition flex items-center justify-center gap-2">
                        Edit Stats
                    </a>
                    <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Hapus permanen pemain ini?')" class="bg-red-600 hover:bg-red-700 text-white px-4 rounded-lg font-bold transition flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2 flex flex-col justify-center items-center z-10">
                <h2 class="text-2xl font-bold text-slate-300 mb-4 stat-font tracking-widest">PERFORMANCE ANALYSIS</h2>
                
                <div class="w-full h-[400px] relative">
                    <canvas id="playerChart"></canvas>
                </div>

                <div class="grid grid-cols-4 gap-4 mt-6 w-full text-center">
                    <?php
                    $isGK = ($p['posisi'] == 'Goalkeeper');
                    $statsMap = [
                        ($isGK ? 'SPEED' : 'SPEED')      => $p['speed'],
                        ($isGK ? 'KICK' : 'SHOOT')       => $p['shooting'],
                        ($isGK ? 'HAND' : 'PASS')        => $p['passing'],
                        ($isGK ? 'DIVING' : 'DRIBBLE')   => $p['dribbling'],
                        ($isGK ? 'REFLEX' : 'DEFEND')    => $p['defending'],
                        ($isGK ? 'POS' : 'PHYSICAL')     => $p['physical'],
                        ($isGK ? 'REACT' : 'STAMINA')    => $p['stamina']
                    ];

                    foreach($statsMap as $label => $val):
                    ?>
                    <div class="bg-slate-800 p-2 rounded-lg border border-slate-700">
                        <span class="block text-xs text-slate-400"><?= $label ?></span>
                        <span class="text-xl font-bold text-cyan-400 stat-font"><?= $val ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div> 
    </div> 

    <script>
        const ctx = document.getElementById('playerChart').getContext('2d');
        const stats = [
            <?= $p['speed'] ?>, <?= $p['shooting'] ?>, <?= $p['passing'] ?>, 
            <?= $p['dribbling'] ?>, <?= $p['defending'] ?>, <?= $p['physical'] ?>, <?= $p['stamina'] ?>
        ];

        const labels = [
            '<?= $isGK ? "SPD" : "PAC" ?>', 
            '<?= $isGK ? "KIC" : "SHO" ?>', 
            '<?= $isGK ? "HAN" : "PAS" ?>', 
            '<?= $isGK ? "DIV" : "DRI" ?>', 
            '<?= $isGK ? "REF" : "DEF" ?>', 
            '<?= $isGK ? "POS" : "PHY" ?>', 
            '<?= $isGK ? "REA" : "STA" ?>'
        ];

        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stats',
                    data: stats,
                    backgroundColor: 'rgba(34, 211, 238, 0.4)',
                    borderColor: '#22d3ee',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#22d3ee',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: '#334155' },
                        grid: { color: '#334155' },
                        pointLabels: { color: '#94a3b8', font: { size: 14, family: 'Oswald' } },
                        suggestedMin: 0, suggestedMax: 100,
                        ticks: { display: false }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>