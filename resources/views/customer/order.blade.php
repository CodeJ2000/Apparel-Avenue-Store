<x-Base-Layout>
    <section id="page-header" class="about-header">
        <h2>#Order_History</h2>
        <p>Track you orders</p>
      </section>
      <section id="cart" class="section-p1">
        <table width="100%">
          <thead>
            <tr>
              <td>Order ID</td>
              <td>Date of Order</td>
              <td>Shipping Address</td>
              <td>Total Amount</td>
              <td>Status</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td>
                  12
                </td>
                <td>July 6, 2023</td>
                <td>Prk. Centro Brgy. San Jose Tandag City</td>
                <td>$118.19</td>
                <td>Shipped</td>
                <td><button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #088178; color: white" class="btn btn-sucess">View details</button></td>
              </tr>
              <tr>
                <td>
                  12
                </td>
                <td>July 6, 2023</td>
                <td>Prk. Centro Brgy. San Jose Tandag City</td>
                <td>$118.19</td>
                <td>Shipped</td>
                <td><button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #088178; color: white" class="btn btn-sucess">View details</button></td>
              </tr>
              <tr>
                <td>
                  12
                </td>
                <td>July 6, 2023</td>
                <td>Prk. Centro Brgy. San Jose Tandag City</td>
                <td>$118.19</td>
                <td>Shipped</td>
                <td><button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #088178; color: white" class="btn btn-sucess">View details</button></td>
              </tr>
              <tr>
                <td>
                  12
                </td>
                <td>July 6, 2023</td>
                <td>Prk. Centro Brgy. San Jose Tandag City</td>
                <td>$118.19</td>
                <td>Shipped</td>
                <td><button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #088178; color: white" class="btn btn-sucess">View details</button></td>
              </tr>
              <tr>
                <td>
                  12
                </td>
                <td>July 6, 2023</td>
                <td>Prk. Centro Brgy. San Jose Tandag City</td>
                <td>$118.19</td>
                <td>Shipped</td>
                <td><button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background: #088178; color: white" class="btn btn-sucess">View details</button></td>
              </tr>
          </tbody>
        </table>
        <hr>
      </section>
      <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table width="100%">
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
                  <tr>
                    
                    <td><img width="60px" src="{{ asset('images/products/f1.jpg') }}" alt="" /></td>
                    <td>Cartoon Astronaut T-Shirts</td>
                    <td>$118.19</td>
                    <td>2</td>
                    <td>$118.19</td>
                  </tr>
                  <tr>
                    
                    <td><img width="60px" src="{{ asset('images/products/f1.jpg') }}" alt="" /></td>
                    <td>Cartoon Astronaut T-Shirts</td>
                    <td>$118.19</td>
                    <td>2</td>
                    <td>$118.19</td>
                  </tr>
                  <tr>
                    <td><img width="60px" src="{{ asset('images/products/f1.jpg') }}" alt="" /></td>
                    <td>Cartoon Astronaut T-Shirts</td>
                    <td>$118.19</td>
                    <td>2</td>
                    <td>$118.19</td>
                  </tr>
                </tbody>
              </table>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</x-Base-Layout>