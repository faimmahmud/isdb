import React from 'react'
import Header from '../components/Header';
import Nav from '../components/Nav';
import Footer from '../components/Footer';

export default function Events() {
    const shoot = () => {
        alert("🎉 Great Shot! You nailed it!");
    }
    
    return (
        <div className="d-flex flex-column min-vh-100 bg-light">
            <Header />
            <Nav />
            
            <main className="flex-grow-1 d-flex align-items-center justify-content-center py-5">
                <div className="card shadow-lg border-0 text-center p-4 p-md-5" style={{ maxWidth: '420px', borderRadius: '15px' }}>
                    <div className="display-4 mb-3">🎯</div>
                    
                    <h1 className="fw-bold text-dark h2 mb-2">React Click Event</h1>
                    
                    <p className="text-muted small mb-4">
                        নিচের বাটনে ক্লিক করে React-এর ইভেন্ট হ্যান্ডলার পরীক্ষা করুন।
                    </p>
                    
                    <div className="d-grid col-10 mx-auto">
                        <button 
                            onClick={shoot} 
                            className="btn btn-primary btn-lg rounded-pill fw-semibold shadow-sm"
                        >
                            🚀 Take the shot!
                        </button>
                    </div>
                </div>
            </main>

            <Footer />
        </div>
    )
}
