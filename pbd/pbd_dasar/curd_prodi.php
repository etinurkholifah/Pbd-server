<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Studi CRUD</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e6e6e6;
            margin: 20px;
            color: #555;
        }

        h2 {
            color: #009688;
        }

        th {
            background-color: #009688;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            color: #333;
        }

        th#id,
        td#id {
            color: #2196F3;
        }

        th#kode,
        td#kode {
            color: #FF5722;
        }

        th#nama-prodi,
        td#nama-prodi {
            color: #673AB7;
        }

        th#akreditasi,
        td#akreditasi {
            color: #E91E63;
        }

        a {
            text-decoration: none;
            padding: 8px;
            margin: 5px;
            border-radius: 3px;
            font-weight: bold;
            color: #fff;
        }

        a.input-btn {
            background-color: #4caf50;
        }

        a.edit-btn {
            background-color: #ffc107;
            color: #333;
        }

        a.delete-btn {
            background-color: #e57373;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="radio"],
        input[type="submit"] {
            margin-bottom: 10px;
            padding: 12px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">

        <?php
        require("../sistem/koneksi.php");
        $hub = open_connection();
        $a = @$_GET["a"];
        $id = @$_GET["id"];
        $sql = @$_POST["sql"];
        switch ($sql) {
            case "create":
                create_prodi();
                break;
            case "update":
                update_prodi();
                break;
            case "delete":
                delete_prodi();
                break;
        }
        switch ($a) {
            case "list":
                read_data();
                break;
            case "input":
                input_data();
                break;
            case "edit":
                edit_data($id);
                break;
            case "hapus":
                hapus_data($id);
                break;
            default:
                read_data();
                break;
        }
        mysqli_close($hub);
        ?>

    <?php
    function read_data() {
        global $hub;
        $query = "select * from dt_prodi";
        $result = mysqli_query($hub, $query);
        ?>
        <h2>Daftar Program Studi</h2>
        <a class="input-btn" href="curd_prodi.php?a=input">Input Data</a>
        <table>
            <tr>
                <th>Id</th>
                <th>Kode</th>
                <th>Nama Prodi</th>
                <th>Akreditasi</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['idprodi']; ?></td>
                    <td><?php echo $row['kdprodi']; ?></td>
                    <td><?php echo $row['nmprodi']; ?></td>
                    <td><?php echo $row['akreditasi']; ?></td>
                    <td>
                        <a class="edit-btn" href="curd_prodi.php?a=edit&id=<?php echo $row['idprodi']; ?>">Edit</a>
                        <a class="delete-btn" href="curd_prodi.php?a=hapus&id=<?php echo $row['idprodi']; ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    ?>

    <?php
    function input_data() {
        $row = array(
            "kdprodi" => "",
            "nmprodi" => "",
            "akreditasi" => "-"
        );
        ?>
        <h2>Input Data Program Studi</h2>
        <form action="curd_prodi.php?a=list" method="post">
            <input type="hidden" name="sql" value="create">
            Kode Prodi
            <input type="text" name="kdprodi" maxlength="6" size="6" value="<?php echo trim($row["kdprodi"]) ?>" /><br>
            Nama Prodi
            <input type="text" name="nmprodi" maxlength="70" size="70" value="<?php echo trim($row["nmprodi"]) ?>" /><br>
            Akreditasi Prodi
            <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"] == '-' || $row["akreditasi"] == '') {
                echo "checked=\"checked\"";
            } else {
                echo "";
            } ?>> -
            <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"] == 'A') {
                echo "checked=\"checked\"";
            } else {
                echo "";
            } ?> > A
            <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"] == 'B') {
                echo "checked=\"checked\"";
            } else {
                echo "";
            } ?> > B
            <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"] == 'C') {
                echo "checked=\"checked\"";
            } else {
                echo "";
            } ?> > C
            <br><input type="submit" name="action" value="Simpan"><br>
            <a href="curd_prodi.php?a=list">Batal</a>
        </form>
        <?php
    }
    ?>

    <?php
    function edit_data($id) {
        global $hub;
        $query = "select * from dt_prodi where idprodi = $id";
        $result = mysqli_query($hub, $query);
        $row = mysqli_fetch_array($result);
        ?>
        <h2>Edit Data Program Studi</h2>
        <form action="curd_prodi.php?a=list" method="post">
            <input type="hidden" name="sql" value="update">
            <input type="hidden" name="idprodi" value="<?php echo trim($id) ?>">
            Kode Prodi
            <input type="text" name="kdprodi" maxlength="6" size="6" value="<?php echo trim($row["kdprodi"]) ?>" /><br>
            Nama Prodi
            <input type="text" name="nmprodi" maxlength="70" size="70" value="<?php echo trim($row["nmprodi"]) ?>" /><br>
            Akreditasi Prodi
            <input type="radio" name="akreditasi" value="-" <?php if ($row["akreditasi"] == '-' || $row["akreditasi"] == '') {
                echo "checked=\"checked\"";
            } else {
                echo "";
            } ?>> -
            <input type="radio" name="akreditasi" value="A" <?php if ($row["akreditasi"] == 'A') {
                echo "checked=\"checked\"";
            } else {
                echo "";
            } ?> > A
            <input type="radio" name="akreditasi" value="B" <?php if ($row["akreditasi"] == 'B') {
                echo "checked=\"checked\"";
            } else {
                echo "";
            } ?> > B
            <input type="radio" name="akreditasi" value="C" <?php if ($row["akreditasi"] == 'C') {
                echo "checked=\"checked\"";
            } else {
                echo "";
            } ?> > C
            <br><input type="submit" name="action" value="Simpan"><br>
            <a href="curd_prodi.php?a=list">Batal</a>
        </form>
        <?php
    }
    ?>

    <?php
    function hapus_data($id) {
        global $hub;
        $query = "select * from dt_prodi where idprodi = $id";
        $result = mysqli_query($hub, $query);
        $row = mysqli_fetch_array($result);
        ?>
        <h2>Delete Data Program Studi</h2>
        <form action="curd_prodi.php?a=list" method="post">
            <input type="hidden" name="sql" value="delete">
            <input type="hidden" name="idprodi" value="<?php echo trim($id) ?>">
            <table>
                <tr><td width=100>Kode</td><td><?php echo trim($row["kdprodi"]) ?></td></tr>
                <tr><td>Nama Prodi</td><td><?php echo trim($row["nmprodi"]) ?></td></tr>
                <tr><td>Akreditasi</td><td><?php echo trim($row["akreditasi"]) ?></td></tr>
            </table>
            <br><input type="submit" name="action" value="Hapus"><br>
            <a href="curd_prodi.php?a=list">Batal</a>
        </form>
        <?php
    }
    ?>
    <?php
    function create_prodi()
    {
        global $hub;
        global $_POST;
        $query = "insert into dt_prodi (kdprodi, nmprodi, akreditasi) values ";
        $query .= " ('" . $_POST["kdprodi"] . "', '" . $_POST["nmprodi"] . "', '" . $_POST["akreditasi"] . "')";
        mysqli_query($hub, $query) or die(mysqli_error($hub));
    }
    
    function update_prodi()
    {
        global $hub;
        global $_POST;
        $query = "update dt_prodi ";
        $query .= " SET kdprodi='" . $_POST["kdprodi"] . "', nmprodi= '" . $_POST["nmprodi"] . "', akreditasi='" . $_POST["akreditasi"] . "'";
        $query .= " WHERE idprodi = " . $_POST["idprodi"];
        mysqli_query($hub, $query) or die(mysqli_error($hub));
    }
    
    function delete_prodi()
    {
        global $hub;
        global $_POST;
        $query = "DELETE FROM dt_prodi ";
        $query .= " WHERE idprodi = " . $_POST["idprodi"];
        mysqli_query($hub, $query) or die(mysqli_error($hub));
    }    
    ?>
</div>
</body>
</html>