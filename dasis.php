<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Form Data Siswa</title>
    <style>
        body {
            background: #f2f2f2;
            font-family: sans-serif;
        }

        .form-siswa {
            width: 980px;
            margin: 100px auto;
            padding: 10px 20px 50px 20px;
            border-radius: 5px;
            box-shadow: 0px 10px 20px 0px #d1d1d1;
            background-color: white;
        }

        .input-field {
            width: 300px;
            border: none;
            font-size: 16pt;
            border-radius: 5px;
            padding: 10px;
            margin: 5px;
        }

        .input-container {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .label {
            width: 200px;
            text-align: right;
            margin-right: 20px;
            font-size: 16pt;
        }

        .submit-button, .cetak-button, .edit-button, .delete-button, .reset-button, .detail-button {
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 15pt;
            cursor: pointer;
        }

        .submit-button {
            background: lightgreen;
            color: rgb(29, 27, 27);
        }

        .cetak-button {
            background: blue;
            color: white;
        }

        .edit-button {
            background: orange;
            color: white;
            font-size: 10pt;
            margin-right: 10px;
        }

        .delete-button {
            background: red;
            color: white;
            font-size: 10pt;
        }

        .detail-button {
            background: lightblue;
            color: black;
            font-size: 10pt;
        }

        .judul {
            text-align: center;
            color: black;
            font-weight: normal;
            margin-top: 50px;
            font-size: 3rem;
        }

        .reset-button {
            background: lightgray;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: black;
            font-size: 15pt;
            cursor: pointer;
            text-decoration: none;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            background-color: #fff;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>

<?php 
    session_start(); 

    if(!isset($_SESSION['datasiswa'])) {
        $_SESSION['datasiswa'] = array(); 
    }


    if(isset($_POST['submit']) && isset($_POST['nama']) && isset($_POST['nis']) && isset($_POST['rayon'])) {
        $data = [
            'nama' => htmlspecialchars($_POST['nama']), 
            'nis' => htmlspecialchars($_POST['nis']), 
            'rayon' => htmlspecialchars($_POST['rayon'])
        ]; 
        
        array_push($_SESSION['datasiswa'], $data);
    }


    if(isset($_POST['delete'])) {
        $index = $_POST['index'];
        array_splice($_SESSION['datasiswa'], $index, 1);
    }


    if(isset($_POST['edit'])) {
        $index = $_POST['index'];
        $_SESSION['editIndex'] = $index;
    }


    if(isset($_POST['update'])) {
        $index = $_POST['index'];
        $_SESSION['datasiswa'][$index] = [
            'nama' => htmlspecialchars($_POST['nama']),
            'nis' => htmlspecialchars($_POST['nis']),
            'rayon' => htmlspecialchars($_POST['rayon'])
        ];
        unset($_SESSION['editIndex']);
    }
?>

<h2 class="judul">Form Data Siswa</h2>
<div class="form-siswa">
    <form method="post" action="">
        <div class="input-container">
            <label class="label">Nama</label>
            <input type="text" name="nama" class="input-field" autocomplete="off" placeholder="Masukkan nama" required>
        </div>
        <div class="input-container">
            <label class="label">NIS</label>
            <input type="text" name="nis" class="input-field" autocomplete="off" placeholder="Masukkan NIS" required>
        </div>
        <div class="input-container">
            <label class="label">Rayon</label>
            <input type="text" name="rayon" class="input-field" autocomplete="off" placeholder="Masukkan Rayon" required>
        </div>
        <div class="button-container">
            <input type="submit" name="submit" value="Submit" class="submit-button">
            <button type="button" class="cetak-button" onclick="window.print()">Cetak</button>
            <a href="reset.php" class="reset-button">Reset</a>
        </div>
    </form>

    <div class="input-container" style="flex-direction: column; align-items: center;">
        <h3>Data Siswa Tersimpan:</h3>
        <?php if (!empty($_SESSION['datasiswa'])) { ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Rayon</th>
                    <th>Actions</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['datasiswa'] as $index => $siswa) { ?>
                    <?php if(isset($_SESSION['editIndex']) && $_SESSION['editIndex'] == $index) { ?>
                        <tr>
                            <form method="post" action="">
                                <td><?php echo $index + 1; ?></td>
                                <td>
                                    <input type="text" name="nama" class="input-field" value="<?php echo $siswa['nama']; ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="nis" class="input-field" value="<?php echo $siswa['nis']; ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="rayon" class="input-field" value="<?php echo $siswa['rayon']; ?>" required>
                                </td>
                                <td class="action-buttons">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <input type="submit" name="update" value="Update" class="submit-button">
                                </td>
                                <td></td>
                            </form>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $siswa['nama']; ?></td>
                            <td><?php echo $siswa['nis']; ?></td>
                            <td><?php echo $siswa['rayon']; ?></td>
                            <td class="action-buttons">
                                <form method="post" action="" class="edit-form" style="display:inline;">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <input type="submit" name="edit" value="Edit" class="edit-button">
                                </form>
                                <form method="post" action="" class="delete-form" style="display:inline;">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <input type="submit" name="delete" value="Delete" class="delete-button">
                                </form>
                            </td>
                            <td>
                                <button class="detail-button" onclick="alert('Nama: <?php echo $siswa['nama']; ?>\nNIS: <?php echo $siswa['nis']; ?>\nRayon: <?php echo $siswa['rayon']; ?>')">Detail</button>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            <p>No data available.</p>
        <?php } ?>
    </div>
</div>

</body>
</html>
