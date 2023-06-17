<div class="list">
  <section>
    <div class="message">
      <?php
      if (!empty($params['error'])) {
        switch ($params['error']) {
          case 'missingNoteId':
            echo 'Niepoprawny identyfikator notatki';
            break;
          case 'noteNotFound':
            echo 'Notatka nie została znaleziona';
            break;
        }
      }
      ?>
    </div>
    <div class="message">
      <?php
      if (!empty($params['before'])) {
        switch ($params['before']) {
          case 'created':
            echo 'Notatka zostało utworzona';
            break;
          case 'deleted':
            echo 'Notatka została usunięta';
            break;
          case 'edited':
            echo 'Notatka została zaktualizowana';
            break;
        }
      }
      ?>
    </div>
    <div>
      Data aktualizacji:
      <?php
          echo $params['date'];
      ?>
    </div>
    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="tbl-content">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
          <?php foreach ($params['currencyRates'] ?? [] as $rate) : ?>
            <tr>
              <td><?php echo $rate['name'] ?></td>
              <td><?php echo $rate['code'] ?></td>
              <td><?php echo $rate['value'] ?> PLN</td>
              <td><button> convert currency </button></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>