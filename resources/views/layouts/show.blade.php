<!-- resources/views/layouts/show.blade.php -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalSpinner" class="text-center" style="display: none;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="modalProductContent">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="" id="modalProductImage" class="img-fluid mb-3" alt="Product Image" style="max-height: 400px; width: 100%; object-fit: contain; border: 1px solid #eee; padding: 10px; border-radius: 8px;">
                        </div>
                        <div class="col-md-7">
                            <h3 id="modalProductName" class="fw-bold"></h3>
                            <p class="text-muted mb-2"><small>Category: <span id="modalProductCategory"></span></small></p>
                            <h4 class="mb-3" id="modalProductPrice" style="color: #28dbd1;"></h4>
                            <p id="modalProductDescription" style="min-height: 80px; font-size: 0.95rem;"></p>
                            <hr>
                            <!-- Form Add to Cart di dalam Modal -->
                            <form action="{{ route('cart.add') }}" method="POST" id="modalAddToCartForm">
                                @csrf
                                <input type="hidden" name="product_id" id="modalProductId">
                                <div class="row align-items-center">
                                    <div class="col-md-5 mb-3 mb-md-0">
                                        <label for="modalProductQuantity" class="form-label">Quantity:</label>
                                        <input type="number" name="quantity" id="modalProductQuantity" class="form-control form-control-sm" value="1" min="1">
                                    </div>
                                    <div class="col-md-7">
                                        <button type="submit" class="thm-btn w-100"><i class="icon-shopping-cart"></i> Add to Cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>