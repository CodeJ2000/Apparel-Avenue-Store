<x-Admin-Layout>
@push('styles')
  <style>
    #ordersTable td,
    #ordersTable th {
      text-align: center;
      vertical-align: middle;
    }    
  </style>
@endpush
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Money</p>
                <h5 class="font-weight-bolder">
                  $53,000
                </h5>
                <p class="mb-0">
                  <span class="text-success text-sm font-weight-bolder">+55%</span>
                  since yesterday
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Users</p>
                <h5 class="font-weight-bolder">
                  2,300
                </h5>
                <p class="mb-0">
                  <span class="text-success text-sm font-weight-bolder">+3%</span>
                  since last week
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">New Clients</p>
                <h5 class="font-weight-bolder">
                  +3,462
                </h5>
                <p class="mb-0">
                  <span class="text-danger text-sm font-weight-bolder">-2%</span>
                  since last quarter
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                <h5 class="font-weight-bolder">
                  $103,430
                </h5>
                <p class="mb-0">
                  <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                </p>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div  class="col-lg-12 mb-lg-4 mb-5">
      <div class="card z-index-2 h-100">
        <div class="card-header pb-0 pt-3 bg-transparent">
          <h6 class="text-capitalize">Orders</h6>
        </div>
        <div class="card-body p-3">
            <table id="ordersTable" class="table table-striped">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th>Total Amount</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>  
              <tbody>
                <tr>
                  <td colspan="5" class="text-center text-muted">Loading...</td>
                </tr>
              </tbody>
            </table>          
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header pb-0 p-3">
          <button class="mb-0 btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-form" id="openAddCategoryForm">Add Category</button>
        </div>
        <div class="card-body p-3">
          <table id="categoryTable" class="table table-striped">
            <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="3" class="text-center text-muted">Loading...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div> 
    </div>
      <div class="col-lg-6">
      <div class="card">
        <div class="card-header pb-0 p-3">
          <button class="mb-0 btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-size-form" id="openAddSizeForm">Add Size</button>
        </div>
        <div class="card-body p-3">
          <table id="sizeTable" class="table table-striped">
            <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="3" class="text-center text-muted">Loading...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div> 
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade" id="add-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hid den="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add new Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addCategoryForm" role="form" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Category Name</label>
                <div>
                    <input type="text" class="form-control input-lg" name="name">
                    <span class="text-danger ps-2 error-msg name-error" id=""></span>
                </div>
            </div>
            </div>
          </div>
          <div class="form-group">
              <div>
                  <button type="submit" id="add-btn"  class="btn btn-success">
                      Add category
                  </button>
              </div>
          </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hid den="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add new Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editCategoryForm" role="form" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Category Name</label>
                <div>
                    <input type="text" id="name" class="form-control input-lg"  name="name">
                    <span class="text-danger ps-2 error-msg name-error" id=""></span>
                </div>
            </div>
            </div>
          </div>
          <div class="form-group">
              <div>
                  <button type="submit" id="add-category-btn"  class="btn btn-success">
                      Add category
                  </button>
              </div>
          </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateStatusModalLabel">Set status of the order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="setStatusForm" action="" method="POST">
          @csrf
          <div class="form-group">
            <label class="control-label">Status</label>
            <div>
                <select name="status" class="form-control input-lg category_id" id="">
                    <option value="" disabled selected>Select Status</option>
                    <option value="pending" >Pending</option>
                    <option value="cancelled" >Cancelled</option>
                    <option value="on delivery" >On Delivery</option>
                </select>
                <span class="text-danger ps-2 error-msg category_id-error" id=""></span>
            </div>
          </div>
            <button type="submit" class="btn btn-primary" id="status-save-btn">Save changes</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script src="./assets/js/plugins/chartjs.min.js"></script>
<script src="{{ asset('admin/assets/js/jquery-ajax/dataTable.js') }}"></script>
<script>
$(document).ready(function(){

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  const addUrl = "{{ route('admin.category.store') }}";
  const ajaxUrl = "{{ route('admin.categories') }}";
  let editUrl = "{{ route('admin.category.edit', ':id') }}";
  let updateUrl = "{{ route('admin.category.update', ':id') }}"
  let deleteUrl = "{{ route('admin.category.destroy', ':id') }}";
  let categoryColumnsConfig = [
        { data : null,
          searchable: false,
          orderable: false,
          render: function (data, type, row, meta) {
          // Calculate the row number based on the page and page length
          return meta.row + meta.settings._iDisplayStart + 1;
          },
        },              
        { data : 'name', width: '20%'},
        { data : null,
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
              return editAndDeleteBtn(data);
          }
        },
  ];

  let ordersColumnsConfig = [
        { data : 'id'},
        { 
          data : null,
          render: function(data, type, row){
            let fullName = data.user.first_name + ' ' + data.user.last_name;
            return `<td>${fullName}</td>`;
          }
        },
        { data : 'total_amount'},
        { 
          data : 'status',
          render: function(data, type, row){
              return status(data);
          }
        },
        { 
          data : null,
          orderable: false,
          searchable: false,
          render: function(data, type, row){
            if(data.status === "Delivered"){
              return `<span><i class="fa-regular fa-circle-check text-success"></i></span>`;
            }
              return `<button class="btn btn-primary updateStatus-btn" data-id="${data.id}">Update Status</button>`;
          }
        },
  ];

  let sizesColumnsConfig = [
    {    
          data : null,
          searchable: false,
          orderable: false,
          render: function (data, type, row, meta) {
          // Calculate the row number based on the page and page length
          return meta.row + meta.settings._iDisplayStart + 1;
      }
    },
    { data : 'name'},
    { 
      data : null,
      orderable: false,
      searchable: false,
      render: function(data, type, row){
          return editAndDeleteBtn(data);
      }
    }
  ];

  // Displaying the categories in the datatable
  initializedDataTable("#categoryTable", ajaxUrl, categoryColumnsConfig);
  
  //for adding category
  add("#openAddCategoryForm", "#addCategoryForm", addUrl, "#add-category-btn", "Add category", '#categoryTable');

  //for edit the category
  edit('#editCategoryForm', updateUrl, editUrl, "#categoryTable", "Update Category", '{{ csrf_token() }}');

  deleteData('#categoryTable', deleteUrl); //delete selected category

  // Displaying the Orders in the datatable
  initializedDataTable("#ordersTable", "{{ route('admin.orders.get.json') }}", ordersColumnsConfig);
  
  initializedDataTable("#sizeTable", "{{ route('admin.sizes.get.json') }}", sizesColumnsConfig);

  
  //trigger the click event and update the status
  $("#ordersTable").on('click', '.updateStatus-btn', function(e){
    e.preventDefault();
    let orderId = $(this).data('id'); // Id of the selected order 
    $('#updateStatusModal').modal('show'); //show the modal of the update status 

    //Submit the change status form
    $('#setStatusForm').submit(function(e){
      e.preventDefault();
      $('#status-save-btn').text('Saving...').prop('disabled', true);// Disable the button and change the text

      let formData = $('#setStatusForm').serialize(); //Serialize the form data

      //AJAX request for updating the status
      $.ajax({
        url: "orders/" + orderId + "/status",
        method: 'POST',
        data: formData,
        success: function(response){
          Swal.fire({
                      title: "Successful!",
                      text: response.success,
                      icon: "success",
                      showCancelButton: false,
                      showConfirmButton: false,
                      timer: 2000, 
                   });
          $('#ordersTable').DataTable().ajax.reload();//Refresh the datatable when change status successful
          $('#status-save-btn').text('Save Changes').prop('disabled', false);//enabled the botton reset the button text 
          $('#updateStatusModal').modal('hide');// Hide the modal
        },
        error: function(xhr){
          $('#status-save-btn').text('Save Changes').prop('disabled', false);////enabled the botton reset the button text
          Swal.fire({
                      title: "Oops!",
                      text: xhr.responseJSON.success,
                      icon: "warning",
                      showCancelButton: false,
                      showConfirmButton: false,
                      timer: 2000, 
                    });
        }
      }); //End of AJAX request
    }); //End of form submission

  }); //End of update status btn
}); //End of document ready
</script>
@endpush
</x-Admin-Layout>