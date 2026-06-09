import React, { useRef } from 'react';
import Header from '../components/Header';
import Nav from '../components/Nav';
import Footer from '../components/Footer';

export default function CarBooking() {
  const cardRef = useRef(null);

  const handleMouseMove = (e) => {
    const card = cardRef.current;
    const rect = card.getBoundingClientRect();

    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const centerX = rect.width / 2;
    const centerY = rect.height / 2;

    const rotateX = ((y - centerY) / centerY) * -8;
    const rotateY = ((x - centerX) / centerX) * 8;

    card.style.transform = `
      perspective(1200px)
      rotateX(${rotateX}deg)
      rotateY(${rotateY}deg)
      scale(1.02)
    `;
  };

  const resetTilt = () => {
    const card = cardRef.current;
    card.style.transform = `
      perspective(1200px)
      rotateX(0deg)
      rotateY(0deg)
      scale(1)
    `;
  };

  return (
    <>
      <Header />
      <Nav />

      <div style={styles.page}>
        <div
          ref={cardRef}
          style={styles.wrapper}
          onMouseMove={handleMouseMove}
          onMouseLeave={resetTilt}
        >

          {/* FORM */}
          <div style={styles.formBox}>
            <h2 style={styles.title}>Book Your Drive</h2>
            <p style={styles.subtitle}>3D Premium ARC Experience</p>

            <Input label="Full Name" />
            <Input label="Email Address" />

            <div style={styles.inputWrap}>
              <select style={styles.input}>
                <option value=""></option>
                <option>BMW M4</option>
                <option>Audi RS7</option>
                <option>Ford Mustang</option>
              </select>
              <label style={styles.label}>Select Car</label>
            </div>

            <Input label="Preferred Date" />

            <button style={styles.btn}>Confirm Booking</button>
          </div>

          {/* PREVIEW */}
          <div style={styles.previewBox}>
            <div style={styles.glow}></div>

            <img
              src="https://images.unsplash.com/photo-1555215695-3004980ad54e"
              alt="car"
              style={styles.image}
            />

            <h3 style={styles.carTitle}>BMW M4 Competition</h3>

            <p style={styles.carDesc}>
              503 HP • Twin Turbo • Luxury Performance Machine
            </p>

            <div style={styles.badges}>
              <span style={styles.badge}>Luxury</span>
              <span style={styles.badge}>Performance</span>
              <span style={styles.badge}>Elite</span>
            </div>
          </div>

        </div>
      </div>

      <Footer />
    </>
  );
}

/* INPUT */
function Input({ label }) {
  return (
    <div style={styles.inputWrap}>
      <input type="text" required style={styles.input} />
      <label style={styles.label}>{label}</label>
    </div>
  );
}

/* ================= STYLES ================= */

const styles = {
  page: {
    minHeight: '80vh',
    display: 'flex',
    justifyContent: 'center',
    alignItems: 'center',
    background: '#f5f5f5',
    padding: '40px'
  },

  wrapper: {
    display: 'flex',
    width: '950px',
    borderRadius: '20px',
    overflow: 'hidden',
    background: '#fff',
    border: '1px solid #ddd',

    /* IMPORTANT for 3D */
    transformStyle: 'preserve-3d',
    transition: 'transform 0.15s ease-out',

    boxShadow: '0 40px 100px rgba(0,0,0,0.15)'
  },

  formBox: {
    flex: 1,
    padding: '40px',
    background: '#fff',
    transform: 'translateZ(10px)' // DEPTH LAYER
  },

  previewBox: {
    flex: 1,
    padding: '30px',
    background: '#f8f8f8',
    position: 'relative',
    overflow: 'hidden',
    transform: 'translateZ(20px)' // STRONGER DEPTH
  },

  glow: {
    position: 'absolute',
    width: '260px',
    height: '260px',
    background: 'rgba(0,0,0,0.06)',
    borderRadius: '50%',
    filter: 'blur(60px)',
    top: '-50px',
    right: '-50px'
  },

  title: {
    fontWeight: '700',
    marginBottom: '6px'
  },

  subtitle: {
    marginBottom: '25px',
    fontSize: '13px',
    color: '#666'
  },

  inputWrap: {
    position: 'relative',
    marginBottom: '18px'
  },

  input: {
    width: '100%',
    padding: '18px 12px 12px',
    background: '#fff',
    border: '1px solid #ccc',
    borderRadius: '10px',
    outline: 'none'
  },

  label: {
    position: 'absolute',
    left: '12px',
    top: '14px',
    fontSize: '14px',
    color: '#777',
    pointerEvents: 'none'
  },

  btn: {
    width: '100%',
    padding: '14px',
    borderRadius: '10px',
    border: '1px solid #111',
    background: '#111',
    color: '#fff',
    fontWeight: '600',
    cursor: 'pointer'
  },

  image: {
    width: '100%',
    borderRadius: '14px',
    marginBottom: '18px',

    /* subtle live motion */
    animation: 'float 4s ease-in-out infinite'
  },

  carTitle: {
    fontSize: '20px',
    fontWeight: '700'
  },

  carDesc: {
    fontSize: '13px',
    color: '#555'
  },

  badges: {
    marginTop: '15px',
    display: 'flex',
    gap: '8px'
  },

  badge: {
    fontSize: '11px',
    padding: '6px 10px',
    borderRadius: '20px',
    background: '#fff',
    border: '1px solid #ddd'
  }
};