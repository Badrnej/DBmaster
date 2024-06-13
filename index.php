<!DOCTYPE html>
<html>
<head>
    <title>ORM test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
            text-align: center;
            padding: 20px 0;
            background-color: #f9f9f9;
            margin: 0;
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
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #fff;
            background-color: #f56c40;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }

        a:hover {
            background-color: #007bff;
        }

        a.create {
            background-color: #28a745;
        }

        a.create:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>ORM test</h1>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Price</th>
            <th>Updated At</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=orm_project', 'root', '');
        
        // Récupération des données depuis la base de données
        $stmt = $pdo->prepare('SELECT * FROM products');
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Affichage des données dans le tableau
        foreach ($items as $item) {
            echo '<tr>';
            echo '<td>' . $item['id'] . '</td>';
            echo '<td>' . $item['price'] . '</td>';
            echo '<td>' . $item['updated_at'] . '</td>';
            echo '<td>' . $item['created_at'] . '</td>';
            echo '<td>';
            echo '<a href="http://localhost/DBmaster/test-read.php?id=' . $item['id'] . '">Read</a> ';
            echo '<a href="http://localhost/DBmaster/test-update.php?id=' . $item['id'] . '">Update</a> ';
            echo '<a href="http://localhost/DBmaster/test-delete.php?id=' . $item['id'] . '">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </table>

    <br>
    <a href="http://localhost/DBmaster/test-create.php" class="create">Create</a>
</body>
</html>
