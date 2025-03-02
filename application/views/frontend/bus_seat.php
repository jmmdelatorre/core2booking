

  <style>
    .seat {
      width: 50px;
      height: 50px;
    }
    .aisle {
      background-color: #e2e8f0;
      border: none;
      cursor: default;
    }
    .available {
      background-color: #d1d5db;
      border: 1px solid #ccc;
    }
    .selected {
      background-color: #34d399;
      color: white;
    }
  </style>
</head>

  <div class="mb-4 d-flex align-items-center gap-2">
    <button class="btn btn-outline-success"><i class="fas fa fa-user"></i>&nbsp;Driver</button>
   
  </div>
  <div id="seatContainer" class="d-grid" style="grid-template-columns: repeat(6, 60px);"></div>