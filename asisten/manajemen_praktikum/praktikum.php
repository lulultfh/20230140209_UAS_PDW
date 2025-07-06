<?php
// File: praktikum.php
$pageTitle = 'Manajemen Praktikum';
$activePage = 'praktikum';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../../config.php';

$praktikums = mysqli_query($conn, "SELECT * FROM praktikum ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif']
                    },
                    colors: {
                        darkblue: '#213448',
                        midblue: '#547792',
                        lightblue: '#94B4C1',
                        soft: '#ECEFCA'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-soft font-inter">
    <div class="max-w-4xl mx-auto my-12 bg-white rounded-xl shadow-md p-8">
        <h1 class="text-2xl font-bold text-darkblue mb-6">Manajemen Data Praktikum</h1>

        <!-- Form Tambah -->
        <form action="tambah_praktikum.php" method="POST" class="mb-8">
            <div class="grid md:grid-cols-3 gap-4">
                <input type="text" name="namaPrak" required placeholder="Nama Praktikum"
                    class="px-4 py-2 border rounded bg-soft text-darkblue">
                <input type="text" name="dosenPengampu" required placeholder="Dosen Pengampu"
                    class="px-4 py-2 border rounded bg-soft text-darkblue">
                <input type="number" name="semester" required placeholder="Semester"
                    class="px-4 py-2 border rounded bg-soft text-darkblue">
                <button type="submit"
                    class="bg-darkblue hover:bg-midblue text-white px-4 py-2 rounded col-span-3">Tambah</button>
            </div>
        </form>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-midblue text-white">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nama Praktikum</th>
                        <th class="px-4 py-2">Dosen Pengampu</th>
                        <th class="px-4 py-2">Semester</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($praktikums as $prak): ?>
                        <tr class="border-b hover:bg-lightblue/30">
                            <td class="px-4 py-2"><?= $i++ ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($prak['namaPrak']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($prak['dosenPengampu']) ?></td>
                            <td class="px-4 py-2">Semester <?= $prak['semester'] ?></td>
                            <td class="px-4 py-2 space-x-2">
                                <button onclick="editModal(<?= $prak['id'] ?>, '<?= htmlspecialchars($prak['namaPrak']) ?>', '<?= htmlspecialchars($prak['dosenPengampu']) ?>', <?= $prak['semester'] ?>)"
                                    class="bg-lightblue text-darkblue px-3 py-1 rounded hover:bg-midblue hover:text-white">Edit</button>
                                <a href="hapus_praktikum.php?id=<?= $prak['id'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus?')"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow max-w-md w-full">
            <h2 class="text-lg font-semibold text-darkblue mb-4">Edit Praktikum</h2>
            <form method="POST" action="update_praktikum.php">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="namaPrak" id="editNama"
                    class="w-full px-4 py-2 border rounded mb-4 bg-soft text-darkblue" required>
                <input type="text" name="dosenPengampu" id="editDosen"
                    class="w-full px-4 py-2 border rounded mb-4 bg-soft text-darkblue" required>
                <input type="number" name="semester" id="editSemester"
                    class="w-full px-4 py-2 border rounded mb-4 bg-soft text-darkblue" required>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded bg-darkblue hover:bg-midblue text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editModal(id, nama, dosen, semester) {
            document.getElementById('editId').value = id;
            document.getElementById('editNama').value = nama;
            document.getElementById('editDosen').value = dosen;
            document.getElementById('editSemester').value = semester;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>

</html>
