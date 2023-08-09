import {useEffect, useRef, useState} from "react";
import CartTable from "./CartTable";
import axios from "axios";
import Swal from 'sweetalert2'
import { CheckOutlined, CloseOutlined } from '@ant-design/icons';
import { Switch, Space } from 'antd';

function Right(props) {
    let [customers, setCustomers] = useState([]);


    let { carts, setCarts, setStocks, vat } = props;

    let [subtotal, setSubtotal] = useState(0);
    let [grandtotal, setGrandtotal] = useState(0);
    let [vat_amount, setVatAmount] = useState(0);
    let [isVatOn, toggleIsVatOn] = useState(true);

    let flat_discount = useRef(0);



    useEffect(() => {
        setCustomers(props.customers);

        recalculate();

    },[props]);


    const recalculate = () => {
        let subtotal = carts.reduce( (total, cart) => {
            console.log(cart.quantity, cart.medicine.price)
            if ( cart.batch ) {
                let tmpTotal = (cart.quantity * cart.stock.mrp) + total;
                tmpTotal = tmpTotal - (tmpTotal * (cart.discount/100));
                return tmpTotal;
            } else {
                return total;
            }
        },0);

        setSubtotal(subtotal);
        //setReceived(subtotal);
        let gTotal = 0;
        if ( !isVatOn ) {
            gTotal = (subtotal - flat_discount.current.value) * (1 + (vat/100));
        } else {
            gTotal = (subtotal - flat_discount.current.value);
        }
        setGrandtotal(gTotal);
        if ( vat ) {
            setVatAmount( gTotal * ( vat/100 ) )
        }

        //console.log(`gTotal: ${gTotal}, vat_amount: ${vat_amount}, vat: ${vat/100}`)

        document.querySelector("#received").value = Math.ceil(gTotal);
    }
    const pay = () => {
        if ( carts.length == 0  ) return;
        let allBatchSelected = carts.find(cart => {
            return !cart.batch;
        });
        if ( allBatchSelected ) return ;

        let _token = document.querySelector('meta[name="csrf-token"]').content;
        let customer_id = document.querySelector("#customer").value;
        let paid = document.querySelector("#received").value;


        TurnOverlayOn();
        axios.post("/dashboard/pos/pay",{
            _token: _token,
            customer_id: customer_id,
            paid: paid,
            discount: flat_discount.current.value ? flat_discount.current.value : 0,
            vat: isVatOn
        })
        .then(response => {
            if ( response.data.msg == "success" ) {
                setCarts(response.data.carts);
                setStocks(response.data.stocks);
                Swal.fire({
                    title: 'Successful',
                    text: 'Sale Successful',
                    icon: 'success',
                    denyButtonText: `Ok`,
                    confirmButtonText: 'View Invoice',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // window.location = "/dashboard/sales/" + response.data.sale.id + "/invoice";
                        window.open("/dashboard/sales/" + response.data.sale.id + "/invoice", "_blank")
                    } else if (result.isDenied) {

                    }
                })
            } else {

            }
            TurnOverlayOff();
        })
        .catch(err=>{
            console.log(err)
            TurnOverlayOff();
        });

    }

    const reset = () => {

        let _token = document.querySelector('meta[name="csrf-token"]').content;

        TurnOverlayOn();
        axios.post("/dashboard/pos/reset-cart",{
            _token: _token
        })
        .then(response => {
            if ( response.data.msg == "success" ) {
                setCarts(response.data.carts);
            } else {

            }
        })
        .catch(err=>{
            console.log(err)
        });

        TurnOverlayOff();
    }

    function turnOffVat() {

    }

    return (
        <>
            <div id="right">
                <div id="customer-section">
                    <a href="/dashboard/customers/create" target='_blank' id="add-customer-button">
                        <i className="mdi mdi-account-plus mx-1"></i>
                        Add New Customer
                    </a>

                    <select name="customer" id="customer" className="customer">
                        <option value="-1">Walkaway Customer</option>
                        {
                            customers.map((customer, i)=>{
                                return <option key={i} value={customer.id}>{customer.name}</option>
                            })
                        }
                    </select>
                    <a href="/dashboard">
                        <button className="btn btn-primary py-0">
                            <i className="mdi mdi-desktop-mac"></i>
                        </button>
                    </a>
                    <a href="/dashboard/sales" target="_blank">
                        <button id="" className="btn btn-warning py-0">
                            Sales <i className="uil uil-money-withdrawal"></i>
                        </button>
                    </a>
                </div>
                <div id="cash-register">
                    <div id="added-product-list-container">
                        <CartTable carts={carts} setCarts={setCarts} recalculate={recalculate} />
                    </div>
                    <div id="calculations-container" style={{ background: "white", width: "100%" }}>
                        <table>
                            <tbody style={{ background: "white", width: "100%" }}>
                                <tr>
                                    <td style={{ background: "red", color: "white", width:"50%", border:"1px solid #aaa", padding: "10px 10px" }}>
                                        <div style={{ display: "flex", justifyContent: "space-between" }}>
                                            <span>SUB TOTAL </span>
                                            <span id="sub-total">{ subtotal }</span>
                                        </div>
                                    </td>
                                    <td style={{ background: "black", color: "white",  width:"50%", border:"1px solid #aaa", padding: "10px 10px" }}>
                                        <div style={{ display: "flex", justifyContent: "space-between" }}>
                                            <span style={{ width: "50%" }}>FLAT DISCOUNT </span>
                                            <input onChange={recalculate} style={{ width: "30%", textAlign: "right" }} ref={flat_discount} id="discount" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style={{ background: "orange", color: "white",  width:"50%", border:"1px solid #aaa", padding: "10px 10px" }}>
                                        <div style={{ display: "flex", justifyContent: "space-between" }}>
                                            <Space direction="vertical">
                                                <Switch
                                                    checkedChildren={<CheckOutlined />}
                                                    unCheckedChildren={<CloseOutlined />}
                                                    defaultChecked
                                                    onChange={()=> { toggleIsVatOn(!isVatOn); recalculate() }}
                                                />
                                            </Space>
                                            <span>VAT ({ vat }%)</span>
                                            <span id="vat">{ vat_amount.toFixed(2) }</span>

                                        </div>
                                    </td>
                                    <td style={{ background: "brown", color: "white",  width:"50%", border:"1px solid #aaa", padding: "10px 10px" }}>
                                        <div style={{ display: "flex", justifyContent: "space-between" }}>
                                            <span> GRAND TOTAL </span>
                                            <span id="grand-total">{ grandtotal.toFixed(2) }</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style={{  background: "grey", color: "white",  padding: "10px 10px"  }}>
                            <label htmlFor="" style={{ textAlign: "center", width: "70%", display: "inline-block", boxSizing: "border-box" }}>
                                Paying
                                {/*<button className={"btn btn-primary p-0 px-2 mx-3 border-white"} style={{ borderRadius: "2px" }}>Full</button>*/}
                            </label>
                            <input id={"received"} type="number" style={{  margin: "0px", width: "30%", padding: "5px 10px", textAlign: "right", boxSizing: "border-box" }} placeholder={"Paid"} />
                        </div>
                        <button id="pay-button" onClick={pay}>
                            Pay <i className="ri-bank-card-2-fill"></i>
                        </button>
                        <button id="reset-button" onClick={reset}>
                            Reset <i className="ri-close-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </>
    )
}


export default Right;
