import React from 'react';
import Header from '../components/Header';
import Nav from '../components/Nav';
import Footer from '../components/Footer';

export default function Lists() {
  const cars = [
    {
      name: 'Ford Mustang',
      image: 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8'
    },
    {
      name: 'BMW M4',
      image: 'https://images.unsplash.com/photo-1555215695-3004980ad54e'
    },
    {
      name: 'Audi RS7',
      image: 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6'
    }
  ];

  return (
    <>
      <Header />
      <Nav />

      <div className="container py-5">
        <h1 className="text-center mb-5">Luxury Car Collection</h1>

        <div className="row">
          {cars.map((car, index) => (
            <div className="col-md-4 mb-4" key={index}>
              <div
                className="card shadow-lg"
                style={{
                  borderRadius: '20px',
                  overflow: 'hidden'
                }}
              >
                <img
                  src={car.image}
                  alt={car.name}
                  style={{
                    width: '100%',
                    height: '250px',
                    objectFit: 'cover'
                  }}
                />

                <div className="card-body text-center">
                  <h3>{car.name}</h3>

                  <p className="text-muted">
                    Premium performance vehicle with luxury features.
                  </p>

                  <button className="btn btn-primary">
                    Explore
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      <Footer />
    </>
  );
}