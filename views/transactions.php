<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }
            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($contents as $value) {
                    foreach ($value as $value1) {
                        echo '<tr>';
                        echo '<td>' . date('M d, Y', strtotime($value['Date'])) . '</td>';
                        echo '<td>' . $value['Check'] . '</td>';
                        echo '<td>' . $value['Description'] . '</td>';
                        $value['Amount'] = floatval(str_replace(['$', ','], '', $value['Amount']));
                        if ($value['Amount'] < 0) {
                            echo '<td>' . '<span style="color: red;">' . '-' . '$' . number_format(abs($value['Amount']), 2) . '<span>' . '</td>'; 
                        } else {
                            echo '<td>' . '<span style="color: green;">' . '$' . number_format($value['Amount'], 2) . '<span>' . '</td>'; 
                        } 
                        echo '</tr>';
                        break;
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income: </th>
                    <td><?php echo '$' . number_format($totals['Income'], 2) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense: </th>
                    <td><?php echo '-' . '$' . number_format($totals['Expense'], 2) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total: </th>
                    <td><?php echo '$' . number_format($totals['Net'], 2) ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
