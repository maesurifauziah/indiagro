<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="d-flex flex-column-fluid">
							<div class="container">
								<div class="d-flex flex-row">
									<div class="flex-row-fluid ml-lg-8">
										<div class="card card-custom card-transparent mb-20">
											<div class="card-body p-0">
												<div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">
													<div class="wizard-nav">
														<div class="wizard-steps" data-total-steps="2">
															<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
															</div>
															<div class="wizard-step" data-wizard-type="step">
															</div>
														</div>
													</div>
													<div class="card card-custom card-shadowless rounded-top-0">
														<div class="card-body p-0">
															<div class="row justify-content-center py-8 px-8 pt-lg-2 px-lg-10">
																<div class="col-xl-12 col-xxl-7">
																	<div class="pb-0" data-wizard-type="step-content" data-wizard-state="current">
																		<?= form_open('keranjang/checkout', array('id' => 'form_check_out', 'class' => 'form mt-0 mt-lg-10')) ?>
																			<label class="checkbox">
																				<input type="checkbox" name="data_check_all" id="data_check_all"/>
																				<span></span> 
																				<p class="text-dark-75 font-weight-bolder d-block font-size-sm pl-2 pt-2 count-order"></p>
																			</label>
																			<input type="hidden" name="jumlah_data" id="jumlah_data">
																			<div class="scroll scroll-push list-order" data-scroll="true" data-height="300" data-mobile-height="400">								
																			</div>
																			<div class="mt-5 mb-5">
																				<div class="d-flex align-items-around justify-content-around mb-7">
																					<span class="font-weight-bold text-dark font-size-h6 mr-2 count_choose">Total (0)</span>
																					<span class="font-weight-bolder text-primary font-size-h6 text-right total_harga_order">Rp. 0</span>
																					<input type="hidden" name="total_harga_order_value" id="total_harga_order_value" value="0">
																				</div>
																				<div class="d-flex align-items-around justify-content-around mb-7">
																					<textarea class="form-control" name="alamat_kirim" id="alamat_kirim" rows="2" placeholder="Alamat Kirim"></textarea>
																				</div>
																			</div>
																		<?= form_close() ?>
																	</div>
																	<div class="pb-5" data-wizard-type="step-content">
																		<!--begin::Section-->
																		<h4 class="mt-10 mb-10 font-weight-bold text-dark">Tinjau Pesanan Anda</h4>
																		<h6 class="font-weight-bolder mb-3">Alamat:</h6>
																		<div class="text-dark-50 line-height-lg">
																			<div id="alamat_kirim_preview"></div>
																		</div>
																		<div class="separator separator-dashed my-5"></div>
																		<!--end::Section-->
																		<!--begin::Section-->
																		<h6 class="font-weight-bolder mb-3">Detail Order:</h6>
																		<div class="text-dark-50 line-height-lg">
																			<div class="table-responsive">
																				<table class="table" id="table3">
																					<thead>
																						<tr>
																							<th class="pl-0 font-weight-bold text-muted text-uppercase">Nama Barang</th>
																							<th class="text-right font-weight-bold text-muted text-uppercase">Qty (Kg)</th>
																							<th class="text-right font-weight-bold text-muted text-uppercase">Harga Per Kg</th>
																							<th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Jumlah</th>
																						</tr>
																					</thead>
																					<tbody id="detail_order">
																						
																					</tbody>
																					<tfoot>
																						<!-- <tr>
																							<td colspan="2"></td>
																							<td class="font-weight-bolder text-right">Subtotal</td>
																							<td class="font-weight-bolder text-right pr-0">$1538.00</td>
																						</tr> -->
																						<!-- <tr>
																							<td colspan="2" class="border-0 pt-0"></td>
																							<td class="border-0 pt-0 font-weight-bolder text-right">Delivery Fees</td>
																							<td class="border-0 pt-0 font-weight-bolder text-right pr-0">$15.00</td>
																						</tr> -->
																						<tr>
																							<td colspan="2" class="border-0 pt-0"></td>
																							<td class="border-0 pt-0 font-weight-bolder font-size-lg text-right">Grand Total</td>
																							<td class="border-0 pt-0 font-weight-bolder font-size-lg text-success text-right pr-0 grand_total_preview">Rp. 0</td>
																						</tr>
																					</tfoot>
																				</table>
																			</div>
																		</div>
																	</div>
																	<div class="d-flex justify-content-between border-top mt-5 pt-10">
																		<div class="mr-2">
																			<button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Sebelumnya</button>
																		</div>
																		<div>
																			<button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit" id="submit-btn">Buat Pesanan</button>
																			<button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next" id="checkout-btn">Checkout</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> 
					</div>