from flask import Flask, request, jsonify
import pickle

app = Flask(__name__)

# Load the trained model using pickle
with open('model.pkl', 'rb') as model_file:
    model = pickle.load(model_file)


@app.route('/predict', methods=['GET', 'POST'])
def predict():
    print('predict function triggered')
    try:
        # Get data from JSON POST request
        data = request.get_json()
        print('data')

        # Extract the four integer values from the JSON data
        humidity = data['humidity']
        temperature = data['temperature']
        vibration = data['vibration']
        amperage = data['amperage']

        # Perform predictions using the loaded model
        prediction = model.predict([[humidity, temperature, vibration, amperage]])[0]

        if prediction > 100:
            response = {'prediction': 100}
            return jsonify(response)
        elif  prediction < 0:
            response = {'prediction': 0}
            return jsonify(response)

        # Return the prediction in a dictionary
        response = {'prediction': prediction}

        return jsonify(response)
    except Exception as e:
        return jsonify({'error': str(e)})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)