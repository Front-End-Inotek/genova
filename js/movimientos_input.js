

document.addEventListener("DOMContentLoaded", () => {
    const inputsBoard = [
        ["cantidad[1]" , "unidad[1]" , "claveunidad[1]" , "clave[1]" , "id[1]" , "producto[1]" , "importeuni[1]" , "importe[1]" , "iva[1]" , "ish[1]" , "checisah[1]"],
        ["cantidad[2]" , "unidad[2]" , "claveunidad[2]" , "clave[2]" , "id[2]" , "producto[2]" , "importeuni[2]" , "importe[2]" , "iva[2]" , "ish[2]" , "checisah[2]"],
        ["cantidad[3]" , "unidad[3]" , "claveunidad[3]" , "clave[3]" , "id[3]" , "producto[3]" , "importeuni[3]" , "importe[3]" , "iva[3]" , "ish[3]" , "checisah[3]"],
        ["cantidad[4]" , "unidad[4]" , "claveunidad[4]" , "clave[4]" , "id[4]" , "producto[4]" , "importeuni[4]" , "importe[4]" , "iva[4]" , "ish[4]" , "checisah[4]"],
        ["cantidad[5]" , "unidad[5]" , "claveunidad[5]" , "clave[5]" , "id[5]" , "producto[5]" , "importeuni[5]" , "importe[5]" , "iva[5]" , "ish[5]" , "checisah[5]"],
        ["cantidad[6]" , "unidad[6]" , "claveunidad[6]" , "clave[6]" , "id[6]" , "producto[6]" , "importeuni[6]" , "importe[6]" , "iva[6]" , "ish[6]" , "checisah[6]"],
        ["cantidad[7]" , "unidad[7]" , "claveunidad[7]" , "clave[7]" , "id[7]" , "producto[7]" , "importeuni[7]" , "importe[7]" , "iva[7]" , "ish[7]" , "checisah[7]"],
        ["cantidad[8]" , "unidad[8]" , "claveunidad[8]" , "clave[8]" , "id[8]" , "producto[8]" , "importeuni[8]" , "importe[8]" , "iva[8]" , "ish[8]" , "checisah[8]"],
        ["cantidad[9]" , "unidad[9]" , "claveunidad[9]" , "clave[9]" , "id[9]" , "producto[9]" , "importeuni[9]" , "importe[9]" , "iva[9]" , "ish[9]" , "checisah[9]"],
        ["cantidad[10]" , "unidad[10]" , "claveunidad[10]" , "clave[10]" , "id[10]" , "producto[10]" , "importeuni[10]" , "importe[10]" , "iva[10]" , "ish[10]" , "checisah[10]"],
        ["cantidad[11]" , "unidad[11]" , "claveunidad[11]" , "clave[11]" , "id[11]" , "producto[11]" , "importeuni[11]" , "importe[11]" , "iva[11]" , "ish[11]" , "checisah[11]"],
        ["cantidad[12]" , "unidad[12]" , "claveunidad[12]" , "clave[12]" , "id[12]" , "producto[12]" , "importeuni[12]" , "importe[12]" , "iva[12]" , "ish[12]" , "checisah[12]"],
        ["cantidad[13]" , "unidad[13]" , "claveunidad[13]" , "clave[13]" , "id[13]" , "producto[13]" , "importeuni[13]" , "importe[13]" , "iva[13]" , "ish[13]" , "checisah[13]"],
        ["cantidad[14]" , "unidad[14]" , "claveunidad[14]" , "clave[14]" , "id[14]" , "producto[14]" , "importeuni[14]" , "importe[14]" , "iva[14]" , "ish[14]" , "checisah[14]"],
        ["cantidad[15]" , "unidad[15]" , "claveunidad[15]" , "clave[15]" , "id[15]" , "producto[15]" , "importeuni[15]" , "importe[15]" , "iva[15]" , "ish[15]" , "checisah[15]"],
    ]
    let currentRow = 0;
    let currentCol = 0;

    const moveFocus = (row, col) => {

      const inputId = inputsBoard[row][col];
      const inputElement = document.getElementById(inputId)

      if (inputElement) {
        inputElement.focus();
      }
    };

    //moveFocus(currentRow, currentCol);
    document.addEventListener("keydown", (e) => {

      if (e.key === "ArrowDown") {
        currentRow = Math.min(currentRow + 1, inputsBoard.length - 1);
        moveFocus(currentRow, currentCol);
        console.log(currentRow)
    } else if (e.key === "ArrowUp") {
        currentRow = Math.max(currentRow - 1, 0);
        moveFocus(currentRow, currentCol);
        console.log(currentRow)
    } else if (e.key === "ArrowLeft") {
        currentCol = Math.max(currentCol - 1, 0);
        moveFocus(currentRow, currentCol);
        console.log(currentCol)
    } else if (e.key === "ArrowRight") {
        currentCol = Math.min(currentCol + 1, inputsBoard[currentRow].length - 1);
        moveFocus(currentRow, currentCol);
        console.log(currentCol)
      }
    });

  });