<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Trial Solution</title>
</head>
<body>



<!-- The Modal -->
<div class="modal fade" id="myModal1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <p style="font-family: calibri">Edit Product information below</p>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="">
                @csrf   
                <input type="hidden" name="_method" value="PUT">
                <input type="text" id="id1"  name="id1" />

                <label for="Product Name">Product name</label>
                <input type="text" class="form-control" id="product_name1" name="product_name" placeholder="Name of Product" required /><br><br>

                <label for="Quantity in stock">Quantity in Stock</label>
                <input type="number" class="form-control" id="product_quantity1" name="product_quantity" placeholder="Quantity in stock" required /><br><br>

                <label for="Price per item">Price Per Item</label>
                <input type="number" class="form-control" id="product_price1" name="product_price" placeholder="Price per Item" required /><br><br>
                <center><button type="submit" class="btn btn-primary btn-sm" id="update" >Update</button><center>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



    <div class="container bg-light">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <br>
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-primary" style="text-align: center; font-family: calibri; font-weight: 700">Detail of Products</h4>
                            @if(session()->has('output'))
                                <div class="alert alert-success">
                                    {{ session()->get('output') }}
                                </div>
                            @endif
                    </div>
                    <div class="card-body">

                        <form action="">
                                @csrf   
                                <label for="Product Name">Product name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Name of Product" required /><br><br>

                                <label for="Quantity in stock">Quantity in Stock</label>
                                <input type="number" class="form-control" id="product_quantity" name="product_quantity" placeholder="Quantity in stock" required /><br><br>

                                <label for="Price per item">Price Per Item</label>
                                <input type="number" class="form-control" id="product_price" name="product_price" placeholder="Price per Item" required /><br><br>
                                <center><button type="submit" class="btn btn-primary btn-sm" id="load">Submit</button><center>
                        </form>

                    </div>
                </div>

            </div>

            <div class="col-md-12 mx-auto">
                <br>
                <h4>Product Information</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Quantity</th>
                            <th>Product Price</th>
                            <th>Total price</th>
                            <th>Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $grand_total=0; ?>
                        @foreach($product as $products)
                        <tr>
                            <td>{{$products->product_name}}</td>
                            <td>{{$products->product_quantity}}</td>
                            <td>${{$products->product_price}}</td>
                            <td>${{$total= $products->product_quantity * $products->product_price }}</td>
                            <td>{{$products->created_at }}</td>
                            <td><button type="button" id="edit" class="btn btn-sm btn-primary" value="{{$products->id}}">Edit</button></td>
                        </tr>
                        <?php $grand_total += $total; ?>
                        @endforeach

                        <tr>
                            <td colspan='4' style="text-align: right; font-weight: 900">Grand Total: ${{$grand_total}}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        
    </div>
    
</body>
</html>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

	<script>

		
		$(document).ready(function(){
            $(document).on('click', '#load', function(e){
				var product_name= document.getElementById("product_name").value;
                var product_quantity= document.getElementById("product_quantity").value;
                var product_price= document.getElementById("product_price").value;
					$.ajax({
						type:	"POST",
						url:	"/",
						data: {
                            'product_name': product_name,
                            'product_quantity': product_quantity,
                            'product_price': product_price
                        },
						success:function(res){
							console.log("Data submitted successfuly");
							}
                        })
				})

				

                $(document).on('click', '#edit', function(e){
                    var id= $(this).val();
                    $('#myModal1').modal('show');
                    $.ajax({
                    type: 'GET',
                    url: '/edit/'+ id,
                    success: function(response){
                        $('#id1').val(response.products.id);
                        $('#product_name1').val(response.products.product_name);
                        $('#product_qauntity1').val(response.products.product_quantity);
                        $('#product_price1').val(response.products.product_price);
                    }
                });
            });

            $(document).on('click', '#update', function(){
                    var id=$('#id1').val();
                    var product_name=$('#product_name1').val();
                    var product_quantity=$('#product_quantity1').val();
                    var product_price=$('#product_price1').val();
                    var data1={
                        'product_name': product_name,
                        'product_quantity': product_quantity,
                        'product_price': product_price,
                    }

                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'PUT',
                        url: '/update/'+id,
                        data: data1,
                        dataType: 'json',
                        success: function(response){
                            window.location.reload();
                        }
                    })
            })


        })
                   

	</script>