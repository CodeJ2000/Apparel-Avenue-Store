<x-Admin-Layout>
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
    <div  class="col-lg-7 mb-lg-0 mb-4">
      <div class="card z-index-2 h-100">
        <div class="card-header pb-0 pt-3 bg-transparent">
          <h6 class="text-capitalize">User acounts</h6>
        </div>
        <div class="card-body p-3">
            <table id="userTable" class="table table-striped">
              <thead>
                <tr>
                  <th>sad</th>
                  <th>dasdsa</th>
                  <th>asdsad</th>
                  <th>adsaddsa</th>
                </tr>
              </thead>  
              <tbody>
                <tr>
                  <td colspan="4" class="text-center text-muted">Loading...</td>
                </tr>
              </tbody>
            </table>          
        </div>
      </div>
    </div>
    <div class="col-lg-5">
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
  let columnsConfig = [
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
              return `
              <button id="edit-btn" class="btn btn-primary btn-sm edit-button px-2 py-1" data-id="${data.id}"><i class="fa-regular fa-pen-to-square fs-6" style="color: #ffffff;"></i></button>
              <button class="btn btn-danger btn-sm delete-button px-2 py-1" data-id="${data.id}"><i class="fa-solid fa-trash-can fs-6" style="color: #ffffff;"></i></button>
          `;
          }
        },
  ];

  // Displaying the data in the datatable
  initializedDataTable("#categoryTable", ajaxUrl, columnsConfig);

  //for adding category
  add("#openAddCategoryForm", "#addCategoryForm", addUrl, "Add category");

  //for edit the category
  edit('#editCategoryForm', updateUrl, editUrl, "#categoryTable", "Update Category", '{{ csrf_token() }}');

  deleteData('#categoryTable', deleteUrl)
});
</script>
@endpush
</x-Admin-Layout>