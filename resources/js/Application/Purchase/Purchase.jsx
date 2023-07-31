import {useEffect, useState} from "react";
import Swal from "sweetalert2";

export default function Purchase() {
    const [ medicines, setMedicines ] = useState([]);
    const [ filteredMedicines, setFilteredMedicines ] = useState([]);
    const [ manufacturers, setManufacturers ] = useState([]);
    const [ vendors, setVendors ] = useState([]);

    let [cartMedicines, setCartMedicines] = useState([]);

    let [subtotal, setSubtotal] = useState(0);
    let [discount, setDiscount] = useState(0);
    let [total, setTotal] = useState(0);
    let [paid, setPiad] = useState(0);
    let [due, setDue] = useState(0);

    useEffect(()=>{
        axios.get("/dashboard/purchase/get-page-data")
            .then(response => response.data)
            .then(data => {
                console.log(data)
                if ( data.msg == "success" ) {
                    setMedicines(data.medicines);
                    setManufacturers(data.manufacturers);
                    setVendors(data.vendors);
                }
            });
    },[]);

    const removeFromCartMedicines = (cmid) => {
        let t = cartMedicines.filter(cm=>{
            return cm.id != cmid;
        });
        setCartMedicines(t);
    }

    const selectMedicine = () => {
        let mid = window.event.target.value
        // if already in cart
        let inCart = cartMedicines.find(m => {
            return m.id == mid
        });
        if ( inCart ) return;
        let tmp = medicines.find( m => {
            return m.id == mid
        });
        tmp["subtotal"] = 0;
        tmp["discount"] = 0;
        tmp["total"] = 0;
        tmp["quantity"] = 1;
        tmp["mrp"] = tmp.price;
        tmp["manu_date"] = "";
        tmp["expiry_date"] = "";
        tmp["buy_price"] = 0;
        tmp["batch"] = "";
        setCartMedicines( [...cartMedicines, tmp] );
    }
    const changeMrp = (mid) => {
        let tmp = cartMedicines.map(cm => {
            console.log(mid)
            if ( cm.id == mid ) {
                cm.mrp = window.event.target.value;
            }
            return cm;
        });
        setCartMedicines(tmp);
    }
    const changeDiscount = (mid) => {
        let tmp = cartMedicines.map(cm => {
            console.log(mid)
            if ( cm.id == mid ) {
                cm.discount = window.event.target.value;
            }
            return cm;
        });
        setCartMedicines(tmp);
    }
    const changeUnit = (mid) => {
        let tmp = cartMedicines.map(cm=>{
            console.log(mid)
            if ( cm.id == mid ) {
                cm.quantity = window.event.target.value;
            }
            return cm;
        });
        setCartMedicines(tmp);
    }

    const updateMedicineCalculations = () => {
        let tmpCartMedicines = cartMedicines.map(cm => {
            cm["subtotal"] = cm.mrp * cm.quantity;
            cm["total"] = (cm.mrp * cm.quantity) - cm.discount;

            return cm;
        });

        setCartMedicines(tmpCartMedicines);
        calculateAllTotal();
    }

    const calculateAllTotal = () => {
        let tmpSubtotal = cartMedicines.reduce((total, cm) => {
            return ((cm.mrp * cm.quantity) - cm.discount) + total;
        },0);
        let tmpDiscount = cartMedicines.reduce((total, cm) => {
            return ((cm.mrp * cm.quantity)) + total;
        },0) - tmpSubtotal;
        let tmpTotal = cartMedicines.reduce((total, cm) => {
            return ((cm.mrp * cm.quantity) - cm.discount) + total;
        },0) - tmpDiscount;
        let tmpPaid = tmpTotal;
        let tmpDue = tmpTotal - tmpPaid;

        setSubtotal(tmpSubtotal);
        setDiscount(tmpDiscount);
        setTotal(tmpTotal);
        setPiad(tmpPaid);
        setDue(tmpDue);
    }

    const submit = () => {


        let items = cartMedicines.map(cm => {
            return {
                "medicine_id" : cm.id,
                "manufacturing_date" : document.querySelector(`#cm-${cm.id} #manu_date`).value,
                "expiry_date" : document.querySelector(`#cm-${cm.id} #expiry_date`).value,
                "quantity" : document.querySelector(`#cm-${cm.id} #quantity`).value,
                "mrp" : document.querySelector(`#cm-${cm.id} #mrp`).value,
                "buy_price" : document.querySelector(`#cm-${cm.id} #buy_price`).value,
                "flat_discount" : document.querySelector(`#cm-${cm.id} #discount`).value,
                "batch" : document.querySelector(`#cm-${cm.id} #batch`).value,
            }
        });

        // check if all items are set
        let allSet = items.find(item=>{
            if (!item.manufacturing_date.length) return true;
            if (!item.expiry_date.length) return true;
            if ( item.quantity <= 0) return true;
            if (item.mrp <= 0) return true;
            if (item.buy_price <= 0) return true;
            if (item.flat_discount < 0) return true;

            return false;
        });

        if ( allSet ) {
            return;
        }

        let t = {
            "vendor_id" : document.querySelector("#vendor_id").value,
            "purchase_date" : document.querySelector("#purchase_date").value,
            "paid" : paid
        }
        let _token = document.querySelector('meta[name="csrf-token"]').content;

        axios.post("/dashboard/purchase/store",{
            "items": items,
            "t": t,
            "_token": _token
        })
        .then(r => r.data)
        .then(r => {
            if ( r.msg == "success" ) {
                setCartMedicines([]);
                Swal.fire({
                    title: 'Successful',
                    text: 'Purchase Successful',
                    icon: 'success'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    // if (result.isConfirmed) {
                    //     // window.location = "/dashboard/sales/" + response.data.sale.id + "/invoice";
                    //     window.open("/dashboard/sales/" + response.data.sale.id + "/invoice", "_blank")
                    // } else if (result.isDenied) {
                    //
                    // }
                })
            }
        })
    }

    return (
        <div className="row">
            <div className="col-12">
                <div className="card shadow-none border w-100">

                     {/* End Errors */}
                    <div className="card-header bg-pitla-blue">
                        <h4 className="card-title">Add Purchase</h4>
                    </div>
                    <div className="card-body p-0">
                        <form className="form" method="POST">
                            <div className="row justify-content-center">

                                <div className="form-group col-5 m-1">
                                    <label htmlFor="">Date</label>
                                    <input className="form-control form-control-sm" type="date" name="date" id="purchase_date" />
                                </div>
                                <div className="form-group col-5 m-1">
                                    <label htmlFor="">Manufacturer</label>
                                    <select className="form-select form-select-sm" aria-label="Default select example">
                                        <option selected>Select Manufacturer</option>
                                        {
                                            manufacturers.map((manufacturer,i)=>{
                                                return (
                                                    <option key={i} className="">{ manufacturer.name }</option>
                                                )
                                            })
                                        }
                                    </select>
                                </div>
                                <div className="form-group col-6">
                                    <label htmlFor="">Medicine</label>
                                    <select onChange={()=> selectMedicine() } className="form-select form-select-sm" aria-label="Default select example">
                                        <option selected>Select Medicine</option>
                                        {
                                            medicines.map((medicine,i)=>{
                                                return (
                                                    <option key={i} value={ medicine.id } className="">{ medicine.name }</option>
                                                )
                                            })
                                        }
                                    </select>
                                </div>

                                <div className="form-group col-5 m-1">
                                    <label htmlFor="">Vendor</label>
                                    <select className="form-select form-select-sm" id="vendor_id">
                                        <option selected>Select Vendor</option>
                                        {
                                            vendors.map((vendor,i) => {
                                                return (
                                                    <option key={i} className="" value={vendor.id}>{ vendor.name }</option>
                                                )
                                            })
                                        }
                                    </select>
                                </div>

                                <div className="col-lg-12 mt-3">
                                    <table className="table table-striped mb-0">
                                        <thead className="bg-dark text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Batch</th>
                                            <th>Expiry Date</th>
                                            <th>Manu Date</th>
                                            <th>MRP Per Unit</th>
                                            <th>Buy Price Per Unit</th>
                                            <th>Units</th>
                                            <th>Subtotal</th>
                                            <th>Discount</th>
                                            <th>Total</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {
                                            cartMedicines.map((cm, i)=>{
                                                return (
                                                    <tr key={i} id={"cm-"+cm.id} className={"py-0"}>
                                                        <td className={"py-1"}>{ cm.id }</td>
                                                        <td className={"py-1"}>{ cm.name }</td>
                                                        <td className={"py-1"}>
                                                            <input className="form-control form-control-sm p-1" type="text" id="batch" name="batch" />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <input className="form-control form-control-sm  p-1" type="date" id="manu_date" name="manu_date" />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <input className="form-control form-control-sm  p-1" type="date" id="expiry_date" name="expiry_date" />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <input value={cm.mrp} onChange={ () => { changeMrp(cm.id); updateMedicineCalculations() } } className="form-control form-control-sm  p-1" type="number" id="mrp" name="mrp" />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <input className="form-control form-control-sm  p-1" type="number" id="buy_price" name="buy_price" />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <input value={cm.quantity} min={1} onChange={ () => { changeUnit(cm.id); updateMedicineCalculations() } } className="form-control form-control-sm  p-1" type="number" id="quantity" name="quantity" />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <input style={{ appearance: "textfield" }} value={cm.subtotal} className="form-control form-control-sm  p-1" type="number" id="subtotal" name="subtotal" disabled={true} />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <input value={cm.discount} onChange={ () => { changeDiscount(cm.id); updateMedicineCalculations() } } min={0} className="form-control form-control-sm  p-1" type="number" id="discount" name="discount" />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <input style={{ appearance: "textfield" }} value={cm.total} className="form-control form-control-sm  p-1" type="number" id="total" name="total" disabled={true} />
                                                        </td>
                                                        <td className={"py-1"}>
                                                            <i onClick={()=>removeFromCartMedicines(cm.id)} className="mdi mdi-close text-danger" style={{ cursor: "pointer" }}></i>
                                                        </td>
                                                    </tr>
                                                )
                                            })
                                        }
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div className="col-12 d-flex justify-content-end">
                <div className="card w-25 shadow-none">
                    <div className="card-body p-0 border">
                        <table className="table mb-0">
                            <tbody>
                            <tr>
                                <td className="py-1">Sub Total</td>
                                <td className="py-1">{ subtotal }</td>
                            </tr>
                            <tr>
                                <td className="py-1">Discount</td>
                                <td className="py-1">{ discount }</td>
                            </tr>
                            <tr>
                                <td className="py-1">Total</td>
                                <td className="py-1">{ total }</td>
                            </tr>
                            <tr>
                                <td className="py-1">Paid</td>
                                <td className="py-1">
                                    <input value={paid} className="form-control form-control-sm w-50" type="number" id="paid" name="piad" />
                                </td>
                            </tr>
                            <tr>
                                <td className="py-1">due</td>
                                <td className="py-1">{ due }</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div className="card-header">
                        <div className="form-group col-12 mt-0 text-end">
                            <button onClick={submit} type="submit" className="btn btn-primary me-1 waves-effect waves-float waves-light">Submit
                            </button>
                            <button onClick={() => { setCartMedicines([]); calculateAllTotal(); }} type="reset" className="btn btn-outline-secondary waves-effect">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

