import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Cart, CartItem } from '../models/cart.model';
import { CartService } from '../../services/cart.service';

@Component({
  selector: 'app-cart',
  templateUrl: 'cart.component.html'
})
export class CartComponent implements OnInit {
  cart: Cart = {
    items: [
      {
        product: 'https://via.placeholder.com/150',
        name: 'Snickers',
        price: 150,
        quantity: 1,
        id: 1,
      },
      {
        product: 'https://via.placeholder.com/150',
        name: 'Snickers',
        price: 150,
        quantity: 3,
        id: 2,
      }
    ]
  };
  dataSource: Array<CartItem> = [];
  displayedColumns: Array<string> = [
    'product',
    'name',
    'price',
    'quantity',
    'total',
    'action'
  ];

  constructor(private cartService: CartService, private http: HttpClient) { }

  ngOnInit(): void {
    this.dataSource = this.cart.items;
    this.cartService.cart.subscribe((_cart: Cart) => {
      this.cart = _cart;
      this.dataSource = this.cart.items;
    });
  }

  getTotal(items: Array<CartItem>): number {
    return this.cartService.getTotal(items);
  }

  onClearCart(): void {
    this.cartService.clearCart();
  }

  onRemoveFromCart(item: CartItem): void {
    this.cartService.removeFromCart(item);
  }

  onAddQuantity(item: CartItem): void {
    this.cartService.addToCart(item);
  }

  onRemoveQuantity(item: CartItem): void {
    this.cartService.removeQuantity(item);
  }

  onCheckout() {
    const datetime = new Date().toISOString(); // Aktuelles Datum und Uhrzeit im ISO-Format

    this.http.post('http://localhost/store/api.php', {
      operation: 'write',
      cart: this.cart,
      datetime: datetime // Hinzufügen des datetime Elements
    }).subscribe(response => {
      console.log(response);
      window.open('http://localhost/store/checkout.php', '_blank');
    });
  }





}
