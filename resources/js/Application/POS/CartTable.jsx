import {useEffect, useState} from "react";
import axios from "axios";
import Swal from 'sweetalert2'

export default function CartTable(props) {
    // let [cart, setCart] = useState([]);

    let { carts, setCarts, recalculate } = props
    useEffect(() => {
        console.log(carts)
        // fetch the card
    },[props]);

    const selectBatch = (e, cart_id) => {
        let batch = e.target.value;
        let _token = document.querySelector('meta[name="csrf-token"]').content;

        TurnOverlayOn();
        axios.post("/dashboard/pos/select-batch",{
            _token: document.querySelector('meta[name="csrf-token"]').content,
            cart_id: cart_id,
            batch: batch
        })
        .then(response => {
            if ( response.data.msg == "success" ) {
                console.log("BATCH SELECTED ::: ");
                console.log(response.data.carts)
                setCarts(response.data.carts);
            } else {

            }
            TurnOverlayOff();
        })
        .catch(err=>{
            console.log(err)
            TurnOverlayOff();
        });

    }

    const removeFromCart = (cart_id) => {

        let _token = document.querySelector('meta[name="csrf-token"]').content;

        TurnOverlayOn();
        axios.post("/dashboard/pos/remove-from-cart",{
            _token: _token,
            cart_id: cart_id
        })
        .then(response => {
            if ( response.data.msg == "success" ) {
                console.log(response.data)
                setCarts(response.data.carts);
            } else {

            }
            TurnOverlayOff();
        })
        .catch(err=>{
            console.log(err)
            TurnOverlayOff();
        });


    }

    const increaseQuantity = (cart_id, batch) => {
        let _token = document.querySelector('meta[name="csrf-token"]').content;
        axios.post("/dashboard/pos/increase-quantity",{
            _token: _token,
            cart_id: cart_id,
            batch: batch
        })
        .then(response => {
            if ( response.data.msg == "success" ) {
                console.log(response.data)
                setCarts(response.data.carts);
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-left',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Max Limit Reached For The Product'
                })
            }
            recalculate()
        });
    }
    const decreaseQuantity = (cart_id, batch) => {
        let _token = document.querySelector('meta[name="csrf-token"]').content;
        axios.post("/dashboard/pos/decrease-quantity",{
            _token: _token,
            cart_id: cart_id,
            batch: batch
        })
        .then(response => {
            if ( response.data.msg == "success" ) {
                console.log(response.data)
                setCarts(response.data.carts);
            } else {

            }
        });
        recalculate()
    }

    const setDiscount = (cart_id) => {
        let _token = document.querySelector('meta[name="csrf-token"]').content;
        let discount = window.event.target.value;
        axios.post("/dashboard/pos/set-discount",{
            _token: _token,
            cart_id: cart_id,
            discount: discount
        })
        .then(response => {
            if ( response.data.msg == "success" ) {
                console.log(response.data)
                setCarts(response.data.carts);
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-left',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: 'Discount Set'
                })
            }
        });
    }

    return (
        <>
            <table>
                <thead>
                <tr>
                    <th>MEDICINE</th>
                    <th>BATCH</th>
                    <th>EXPIRY</th>
                    <th>QUANTITY</th>
                    <th>PRICE</th>
                    <th>DISCOUNT %</th>
                    <th>TOTAL</th>
                    <th>
                        <i className="mdi mdi-delete"></i>
                    </th>
                </tr>
                </thead>
                <tbody id="tbody">
                {
                    carts.map((cart, i)=>{
                        return (
                            <tr key={i}>
                                <td style={{ textAlign: "start" }}>{cart.medicine.name}</td>
                                <td>
                                    <select onChange={ () => selectBatch(window.event, cart.id) } style={{ width: "50px" }}>
                                        <option value=""></option>
                                        {
                                            cart.batches.map((batch, i) => {
                                                return (
                                                    <option selected={cart.batch == batch ? true: false} value={batch} key={i}>{batch}</option>
                                                )
                                            })
                                        }
                                    </select>
                                </td>
                                <td>{cart.stock ? cart.stock?.expiry_date : '' }</td>
                                <td>
                                    <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center" }}>
                                        <i onClick={()=>increaseQuantity(cart.id, cart.batch)} className="ri-add-circle-line cursor-pointer" style={{ marginTop: "5px" }}></i>
                                        <input type="number" value={cart.quantity} style={{ width:"3em" }} />
                                        <i onClick={()=>decreaseQuantity(cart.id, cart.batch)}  className="ri-indeterminate-circle-line cursor-pointer"></i>
                                    </div>
                                </td>
                                <td>{cart.stock ? cart.stock.mrp : ''}</td>
                                <td>
                                    <input onChange={ () => setDiscount(cart.id) } type="number" value={cart.discount} style={{ width:"3em" }} />
                                </td>
                                <td>{ cart.stock ? (cart.quantity * cart.stock.mrp) : 0 }</td>
                                <td>
                                    <i onClick={() => removeFromCart(cart.id) } style={{ cursor: "pointer" }} className="mdi mdi-delete"></i>
                                </td>
                            </tr>
                        );
                    })
                }
                </tbody>
            </table>
        </>
    )
}
