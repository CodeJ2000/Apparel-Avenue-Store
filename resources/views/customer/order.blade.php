<x-Base-Layout>
  @push('styles')
    <style>
      #orders-table td,
      #order-items-table td {
        text-align: center;
        vertical-align: middle;
      }    
    </style>
  @endpush
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
          <button class="btn btn-success" id="order-receive-btn">Order Receive</button>
          <button class="btn btn-warning" id="order-cancelled-btn">Cancel Order</bu>
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
                  return status(data);
              }
            },
            { 
              data : null,
              orderable: false,
              searchable: false,
              render: function(data, type, row){
                return `<button type="button" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#order-show-modal" style="background: #088178; color: white" class="btn btn-sucess view-order"><i class="fa-regular fa-eye"></i></button>`;
              }
            }
          ];

          //Render orders in datatable
          initializedDataTable("#orders-table", "{{ route('customer.orders.get.json') }}", columnsConfig);
          

          

          //Handle the view order product when click
          $('#orders-table').on('click', '.view-order', function(e){
            e.preventDefault();
            $('#order-receive-btn').hide();
            $('#order-cancelled-btn').hide();
            let orderId = $(this).data('id'); //store the order id
            
            //GET ajax for retrieving the order data
            $.get('/customer/orders/' + orderId + '/items', function(data){
             
              let status = data[0].order.status;
              if(status === "On Delivery"){
                $('#order-receive-btn').show();
                $('#order-cancelled-btn').hide();
              } else if(status === "Pending") {
                $('#order-receive-btn').hide();
                $('#order-cancelled-btn').show();
                
              }
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

            function updateStatus(btn, btnDefaultText, btnClickedText, url){
              $(btn).text(btnDefaultText)
              $(btn).on('click', function(){
                $(btn).text(btnClickedText)
                $.get(url, function(data){
                  console.log(data);
                  Swal.fire({
                      title: 'Successful!',
                      text: data.success,
                      icon:'success',
                      showCancelButton: false,
                      showConfirmButton: false,
                      timer: 2000
                  });
                  $('#order-show-modal').modal('hide');
                  $('#orders-table').DataTable().ajax.reload();
                });            
              }); 
            }

            //Update status to cancelled
            updateStatus('#order-cancelled-btn', 'Cancel Order', 'Cancelling...', '/customer/orders/' + orderId + '/cancel',);

            //Update status to delivered
            updateStatus('#order-receive-btn', 'Delivered Order', 'Processing...', '/customer/orders/' + orderId + '/delivered',);

             
          }); //End of click view order

        }); //end of document ready
      </script>
  @endpush
</x-Base-Layout>