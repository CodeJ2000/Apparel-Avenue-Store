<x-Admin-Layout>
    @push('styles')
      <style>
        .truncated-description {
              max-width: 150px; /* Adjust the maximum width as needed */
              overflow: hidden;
              text-overflow: ellipsis;
              white-space: nowrap;
          }
          .dataTables_wrapper .dataTables_scrollHead th:last-child,
          .dataTables_wrapper .dataTables_scrollBody td:last-child {
              white-space: nowrap;
          }
  
          .size-input {
              display: flex;
              flex-wrap: wrap;
          }
  
          .size-row {
              display: flex;
              align-items: center;
              margin-right: 20px;
              margin-bottom: 10px;
          }
  
          .size-row label {
              margin-right: 5px;
          }
  
          .size-row input[type="number"] {
              width: 95px; /* Adjust width as needed */
          }
          
  
      </style>
    @endpush
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <button class="btn btn-primary" id="openAddUserForm" data-bs-toggle="modal" data-bs-target="#add-user-modal">Add User</button>
          </div> 
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-5">
              <table id="userTable" class="display">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Created at</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <tr id="loadingRow">
                      <td colspan="6" class="text-center h3 text-muted">Loading...</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal for adding new user -->
  <div class="modal fade reset-modal" id="add-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new product</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="addUserForm" role="form" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">First Name</label>
                  <div>
                    <input type="text" class="form-control input-lg"  name="first_name" value="">
                      <span class="text-danger ps-2 error-msg first_name-error" id=""></span>
                  </div>
                </div>
              <div class="form-group">
                <label class="control-label">Last Name</label>
                <div>
                  <input type="text" class="form-control input-lg"  name="last_name" value="">
                    <span class="text-danger ps-2 error-msg last_name-error" id=""></span>
                </div>
              </div>
              <div class="form-group">
                  <label class="control-label">Email</label>
                  <div>
                      <input type="text" class="form-control input-lg"  name="email">
                      <span class="text-danger ps-2 error-msg email-error" id=""></span>
                  </div>
              </div>
              <div class="form-group">
                <label class="control-label">Password</label>
                  <div>
                      <input type="password" class="form-control input-lg"  name="password">
                      <span class="text-danger ps-2 error-msg password-error" id=""></span>
                  </div>
              </div>
              <div class="form-group">
                <label class="control-label">Confirm Password</label>
                  <div>
                      <input type="password" class="form-control input-lg"  name="password_confirmation">
                      <span class="text-danger ps-2 error-msg password-error" id=""></span>
                  </div>
              </div>
              </div>
            </div>
            <div class="form-group">
                <div>
                    <button type="submit" id="add-user-btn" class="btn btn-success">
                        Add User
                    </button>
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="close-modal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> 
  <div class="modal fade reset-modal" id="edit-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new product</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="editUserForm" role="form" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label">First Name</label>
                  <div>
                    <input type="text" id="first_name" class="form-control input-lg"  name="first_name" value="">
                      <span class="text-danger ps-2 error-msg first_name-error" id=""></span>
                  </div>
                </div>
              <div class="form-group">
                <label class="control-label">Last Name</label>
                <div>
                  <input type="text" id="last_name" class="form-control input-lg"  name="last_name" value="">
                    <span class="text-danger ps-2 error-msg last_name-error" id=""></span>
                </div>
              </div>
              <div class="form-group">
                  <label class="control-label">Email</label>
                  <div>
                      <input type="text" id="email" class="form-control input-lg"  name="email">
                      <span class="text-danger ps-2 error-msg email-error" id=""></span>
                  </div>
              </div>
              <div class="form-group">
                <label class="control-label">Password</label>
                  <div>
                      <input type="password" class="form-control input-lg"  name="password">
                      <span class="text-danger ps-2 error-msg password-error" id=""></span>
                  </div>
              </div>
              <div class="form-group">
                <label class="control-label">Confirm Password</label>
                  <div>
                      <input type="password" class="form-control input-lg"  name="password_confirmation">
                      <span class="text-danger ps-2 error-msg password-error" id=""></span>
                  </div>
              </div>
              </div>
            </div>
            <div class="form-group">
                <div>
                    <button type="submit" id="edit-user-btn" class="btn btn-success">
                        Edit User
                    </button>
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="close-modal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>   
  @push('scripts')
    {{-- script for display datatable & for add, edit and delete data --}}
    <script src="{{asset('admin/assets/js/jquery-ajax/dataTable.js') }}"></script>
  <script>
    
    $(document).ready(function(){
      
      //csrf token for http request
      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
      
      // Initialize the columns configuration for datatable
      let columnsConfig = [
        {    
          data : null,
          searchable: false,
          orderable: false,
          render: function (data, type, row, meta) {
          // Calculate the row number based on the page and page length
          return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
              { data : 'first_name' },
              { data : 'last_name' },
              { data: "email" },
              {
                  data: "created_at",
                  render: function (data, type, row) {
                    return date_format(data)
                },
              },
              {
                  data: null,
                  orderable: false,
                  searchable: false,
                  width: "100px",
                  render: function (data, type, row) {
                    return editAndDeleteBtn(data);
                  },
              },
          ];
  
         
        //displaying product data into the datatable
      initializedDataTable('#userTable', "{{ route('admin.users.list') }}", columnsConfig);
          
      //adding new users
      add("#openAddUserForm", "#add-user-modal", "#addUserForm", "{{ route('admin.users.create') }}", "#add-user-btn", "Add User", "#userTable")

      //edit the user
      edit("#editUserForm", "{{ route('admin.users.update', ':id') }}", "{{ route('admin.users.edit', ':id') }}", "#userTable", "Update User", "{{ csrf_token() }}", "#edit-user-modal")

      deleteData("#userTable", "{{ route('admin.users.destroy', ':id') }}");

      $('.reset-modal').on('hidden.bs.modal', function(){
      $('#addProductForm')[0].reset();
      $('#editProductForm')[0].reset();
      $('.error-msg').html('');
      }); //End reset modal 
    });//End of document ready
  </script>
  @endpush
  </x-Admin-Layout>