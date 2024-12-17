<template>
    <div class="location-picker">
      <!-- Input for showing coordinates -->
      <input
        id="coordinates"
        :value="modelValue"
        type="text"
        class="form-input my-2"
        placeholder="Click on map to pick location"
        readonly
      />
  
      <!-- Map Container -->
      <div ref="mapContainer" class="map"></div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, nextTick, watch } from "vue";
  import L from "leaflet";
  import "leaflet/dist/leaflet.css";
  
  // Props and Emit for v-model
  const props = defineProps({
    modelValue: {
      type: String,
      required: true,
    },
  });
  
  const emit = defineEmits(["update:modelValue"]);
  
  const mapContainer = ref(null);
  let map = null;
  let marker = null;
  
  // Validate and parse coordinates
  const getValidCoordinates = () => {
    try {
      const [lat, lng] = props.modelValue
        .split(",")
        .map((coord) => parseFloat(coord.trim()));
      if (isNaN(lat) || isNaN(lng)) throw new Error("Invalid coordinates");
      return { lat, lng };
    } catch {
      // Fallback to default coordinates
      return { lat: 17.9787, lng: 81.0352 };
    }
  };
  
  // Initialize Leaflet Map
  const initializeMap = () => {
    nextTick(() => {
      const { lat, lng } = getValidCoordinates();
  
      if (!mapContainer.value) {
        console.error("Map container not found");
        return;
      }
  
      map = L.map(mapContainer.value).setView([lat, lng], 10);
  
      // Add Tile Layer (OpenStreetMap)
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: '&copy; OpenStreetMap contributors',
      }).addTo(map);
  
      // Add Marker
      marker = L.marker([lat, lng], { draggable: true }).addTo(map);
  
      // Update coordinates on marker drag
      marker.on("dragend", (e) => {
        const { lat, lng } = e.target.getLatLng();
        updateCoordinates(lat, lng);
      });
  
      // Update marker and coordinates when map is clicked
      map.on("click", (e) => {
        const { lat, lng } = e.latlng;
        updateCoordinates(lat, lng);
        marker.setLatLng([lat, lng]);
      });
    });
  };
  
  // Update Coordinates and Emit Event
  const updateCoordinates = (lat, lng) => {
    const newCoordinates = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
    emit("update:modelValue", newCoordinates);
  };
  
  // Watch for external changes to modelValue and update marker
  watch(
    () => props.modelValue,
    (newVal) => {
      const { lat, lng } = getValidCoordinates();
      if (marker) {
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 10);
      }
    }
  );
  
  onMounted(() => {
    initializeMap();
  });
  </script>
  
  <style scoped>
  .location-picker {
    display: flex;
    flex-direction: column;
  }
  
  .map {
    height: 450px;
    width: 100%;
    margin-top: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  .form-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    box-sizing: border-box;
  }
  </style>
  