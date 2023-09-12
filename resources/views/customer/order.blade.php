<x-Base-Layout>
  <section id="page-header" class="about-header">
        <h2>#Order_History</h2>
        <p>Track you orders</p>
      </section>
      <section  class="section-p1">
        <table id="orders-table" width="100%" class="display">
          <thead>
            <tr>
              <td>Order ID</td>
              <td>Tax</td>
              <td>Total Amount</td>
              <td>Date of Order</td>
              <td>Status</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
        <hr>
      </section>
      <!-- Modal -->
<div class="modal fade" id="order-show-modal" tabindex="-1" aria-labelledby="order-show-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="order-show-modalLabel">Order items</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table width="100%" class="table table-hover" id="order-items-table">
                <thead>
                  <tr>
                    <th>Product Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>quantity</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
      <script src="{{ asset('admin/assets/js/jquery-ajax/dataTable.js') }}"></script>
  
      <script>
        $(document).ready(function(){
          let columnsConfig = [
            { data : 'id'},
            { data : 'tax'},
            { data : 'total_amount'},
            { 
              data : 'created_at',
              render: function(data, type, row){
                return date_format(data)
              }
              
            },
            { 
              data : 'status',
              render: function (data, type, row) {
                  if (data === 'pending') {
                      return '<span class="bg-warning text-white p-2 rounded">' + data + '</span>';
                  } else if (data === 'paid') {
                      return '<span class="bg-primary text-white p-2 rounded">' + data + '</span>';
                  } else if (data === 'on delivery') {
                      return '<span class="bg-info text-white p-2 rounded">' + data + '</span>';
                  } else if (data === 'cancelled') {
                    return '<span class="text-danger text-white p-2 rounded">' + data + '</span>';
                  } else if (data === 'completed') {
                      return '<span class="bg-success text-white p-2 rounded">' + data + '</span>';
                  } else {
                      return data; // Return data as is if no styling is needed
                  }
              }
            },
            { 
              data : null,
              orderable: false,
              searchable: false,
              render: function(data, type, row){
                return `<button type="button" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#order-show-modal" style="background: #088178; color: white" class="btn btn-sucess view-order">View details</button>`;
              }
            }
          ];

          //Render orders in datatable
          initializedDataTable("#orders-table", "{{ route('customer.orders.get.json') }}", columnsConfig);
          
          //Handle the view order product when click
          $('#orders-table').on('click', '.view-order', function(e){
            e.preventDefault();

            let orderId = $(this).data('id'); //store the order id
            
            //GET ajax for retrieving the order data
            $.get('/customer/orders/' + orderId + '/items', function(data){
              
             let tableBody = $('#order-items-table tbody'); //get the table
             
             tableBody.empty(); //empty  the table

             //loop the order products to display in the table
             $.each(data, function(index, item){
                let image = item.product.images[0].image_url;
                let row = $('<tr>');
                  row.append($('<td class="text-center">').html('<img width="60px" src="../../' + image + '" alt="" />'));
                  row.append($('<td class="text-center">').text(item.product.name));
                  row.append($('<td class="text-center">').text(item.product_price));
                  row.append($('<td class="text-center">').text(item.quantity));
                  row.append($('<td class="text-center">').text(item.total_price));
                  
                tableBody.append(row);
             });// End of loop for displaying order products in the table 
            
            }); // End of GET ajax orders

          }); //End of click view order

        }); //end of document ready
      </script>
  @endpush
</x-Base-Layout>