<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dynamic Form</title>
  <style>
    /* Estilos CSS */
    .input-field {
      margin-bottom: 10px;
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col">
        <form id="dynamicForm">
            <div id="modules"></div>
            <button type="button" onclick="addModule()">Add Module</button>
            <button type="submit">Create JSON</button>
        </form>
    </div>
    <div class="col">
      <p>
        <pre id="code">
        </pre>
      </p>
    </div>
  </div>
</div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script>
    // Función para agregar un nuevo módulo al formulario
    let moduleId = 1;
    function addModule() {
      const modulesDiv = document.getElementById('modules');
      const moduleDiv = document.createElement('div');
      moduleDiv.innerHTML = `
        <h2>Module ${moduleId}</h2>
        <input type="text" name="moduleName${moduleId}" placeholder="Module Name"><br>
        <input type="text" name="table_name${moduleId}" placeholder="Tablename"><br>
        <div class="fields" id="fields${moduleId}"></div>
        <button type="button" onclick="addField(${moduleId})">Add Field</button>
        <hr>
      `;
      modulesDiv.appendChild(moduleDiv);
      moduleId++;
    }

    // Función para agregar un nuevo campo a un módulo
    function addField(moduleId) {
      const fieldsDiv = document.getElementById(`fields${moduleId}`);
      const fieldDiv = document.createElement('div');
      fieldDiv.innerHTML = `
        <h3>Field</h3>
        <input type="text" name="fieldName${moduleId}[]" placeholder="Field name"><br>
        <input type="text" name="dataType${moduleId}[]" placeholder="Type"><br>
        <!-- Agregar más campos aquí según la estructura requerida -->
        <hr>
      `;
      fieldsDiv.appendChild(fieldDiv);
    }

    // Función para crear el objeto JSON
    document.getElementById('dynamicForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const modules = [];
      for (let i = 1; i < moduleId; i++) {
        const moduleName = document.querySelector(`input[name="moduleName${i}"]`).value;
        const tableName = document.querySelector(`input[name="table_name${i}"]`).value;
        const fields = [];
        const fieldNames = document.querySelectorAll(`input[name="fieldName${i}[]"]`);
        const dataTypes = document.querySelectorAll(`input[name="dataType${i}[]"]`);
        /* Recorre los campos ingresados y agrégalos a la estructura de campos */
        for (let j = 0; j < fieldNames.length; j++) {
          const fieldName = fieldNames[j].value;
          const dataType = dataTypes[j].value;
          const fieldObj = {
            "db_field_name": fieldName,
            "db_data_type": dataType,
            /* Agregar más propiedades según la estructura requerida */
          };
          fields.push(fieldObj);
        }
        /* Agrega el módulo a la estructura */
        const moduleObj = {
          "name": moduleName,
          "db_table_name": tableName,
          "fields": fields,
          /* Agregar más propiedades según la estructura requerida */
        };
        modules.push(moduleObj);
      }
      /* Crea el objeto final */
      const finalObj = {
        "modules": modules,
        /* Agregar más propiedades según la estructura requerida */
      };
      /* Muestra el objeto JSON en la consola (puedes enviarlo a un servidor o realizar otras operaciones) */
      console.log(JSON.stringify(finalObj, null, 2));
      document.getElementById('code').innerHTML = JSON.stringify(finalObj, null, 2);
    });
  </script>
</body>
</html>
