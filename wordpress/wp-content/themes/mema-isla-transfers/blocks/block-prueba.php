<?php

$json_url = 'https://fp064.techlab.uoc.edu/~uocx5/producto3/api/zonas/reservas';

$response = wp_remote_get($json_url, [
    'timeout' => 10,
]);

if (is_wp_error($response)) {
    echo '<p>No se han podido cargar las estadísticas.</p>';
    return;
}

$data = json_decode(wp_remote_retrieve_body($response), true);

if (!$data || empty($data)) {
    echo '<p>No hay datos disponibles.</p>';
    return;
}
?>

<div class="transfers-stats">
    <h3>Estadísticas de transfers por zona</h3>
    <ul>
        <?php foreach ($data as $zona): ?>
            <li>
                <strong><?php echo esc_html($zona['zona']); ?></strong>:
                <?php echo esc_html($zona['total_traslados']); ?> traslados
                (<?php echo esc_html($zona['porcentaje']); ?>%)
            </li>
        <?php endforeach; ?>
    </ul>
</div>