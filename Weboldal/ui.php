<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛍️ WebShop - Adminisztráció</title>
    <style>
        /* Alapértelmezett stílusok */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            color: #333;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2em;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        /* Server adatok stílusa */
        .server-info {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #555;
            border-left: 5px solid #007bff;
        }

        /* Táblázat stílusok */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        caption {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007bff;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #343a40; /* Sötét háttér a fejléceknek */
            color: white;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Váltakozó sávok */
        }

        tr:hover {
            background-color: #e0f7fa; /* Sor kiemelés egérrel */
        }
        
        /* Új termék űrlap stílusok */
        .new-product-form {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        .new-product-form h2 {
            margin-top: 0;
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        .form-fields {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap; /* Reszponzivitás miatt */
        }

        .form-fields input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex-grow: 1;
            min-width: 150px;
        }

        .form-fields input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-fields input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <header>
        <h1>WebShop Adminisztráció</h1>
    </header>

    <main>
        <div class="server-info">
            <p><strong>Szerver IP Címe:</strong> <?php echo $_SERVER["SERVER_ADDR"]; ?></p>
            <p><strong>Szerver Host Címe:</strong> <?php echo $_SERVER["HOST-ADDRESS"]; ?></p>
        </div>

        <section class="product-list">
            <table>
                <caption>Termékek Listája</caption>
                <thead>
                    <tr>
                        <th>Név</th>
                        <th>Típus</th>
                        <th>Érték (Adat)</th>
                        <th>Ár</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // CSERÉLD KI A <ip> RÉSZT A VALÓDI IP CÍMRE!
                        $ch = curl_init( "<ip>:80/list" );
                        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                        $response = curl_exec( $ch );
                        $json = json_decode( $response );

                        if ( isset( $json->{"response-code"} ) && $json->{"response-code"} != "200" ) {
                            echo '<tr><td colspan="4" style="text-align: center; color: red;">Hiba: ' . htmlspecialchars($json->{"response-msg"}) . '</td></tr>';
                        } elseif ( isset( $json->data ) && is_array($json->data) ) {
                            foreach ( $json->data as $data ) {
                                echo "<tr>";
                                echo "  <td>" . htmlspecialchars($data->name) . "</td>";
                                echo "  <td>" . htmlspecialchars($data->type) . "</td>";
                                echo "  <td>" . htmlspecialchars($data->value) . "</td>";
                                echo "  <td>" . htmlspecialchars($data->price) . " Ft</td>";
                                echo "</tr>";
                            }
                        } else {
                             echo '<tr><td colspan="4" style="text-align: center; color: orange;">Nincs megjeleníthető termék, vagy érvénytelen válasz érkezett.</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <section class="new-product-form">
            <h2>➕ Új termék hozzáadása</h2>
            <form action="/newproduct.php" method="post" class="form-fields">
                <input type="text" name="prod_name" placeholder="Termék neve" required />
                <input type="text" name="prod_type" placeholder="Termék típusa" required />
                <input type="text" name="prod_value" placeholder="Érték (pl. méret, szín)" required />
                <input type="text" name="prod_price" placeholder="Ár (pl. 19900)" required pattern="[0-9]*" title="Csak számokat adjon meg!" />
                <input type="submit" value="Termék Mentése" />
            </form>
        </section>
    </main>
</body>
</html>
